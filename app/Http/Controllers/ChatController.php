<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\PdfFile;
use App\Services\DeepSeekService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser;

class ChatController extends Controller
{
    private $deepSeekService;

    public function __construct(DeepSeekService $deepSeekService)
    {
        $this->deepSeekService = $deepSeekService;
    }

    public function index($conversationId = null)
    {
        $conversations = Conversation::where('user_id', auth()->id())
            ->orderBy('updated_at', 'desc')
            ->get();

        $currentConversation = null;
        $messages = [];

        if ($conversationId) {
            $currentConversation = Conversation::where('id', $conversationId)
                ->where('user_id', auth()->id())
                ->firstOrFail();
            $messages = $currentConversation->messages()->orderBy('created_at')->get();
        }

        return view('chat.app', compact('conversations', 'currentConversation', 'messages'));
    }

    public function history()
    {
        $conversations = Conversation::where('user_id', auth()->id())
            ->with(['messages' => function($query) {
                $query->orderBy('created_at', 'desc')->limit(1);
            }])
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('chat.history', compact('conversations'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:4000',
            'conversation_id' => 'nullable|exists:conversations,id',
        ]);

        // Sanitizar entrada do usuário
        $sanitizedMessage = strip_tags($request->message);

        // Criar ou obter conversa
        if ($request->conversation_id) {
            $conversation = Conversation::where('id', $request->conversation_id)
                ->where('user_id', auth()->id())
                ->firstOrFail();
        } else {
            $conversation = Conversation::create([
                'title' => substr($sanitizedMessage, 0, 50) . (strlen($sanitizedMessage) > 50 ? '...' : ''),
                'user_id' => auth()->id(),
            ]);
        }

        // Salvar mensagem do usuário
        Message::create([
            'conversation_id' => $conversation->id,
            'content' => $sanitizedMessage,
            'sender' => 'user',
        ]);

        // Obter contexto do PDF se existir
        $pdfContext = '';
        $pdfFile = $conversation->pdfFiles()->latest()->first();
        if ($pdfFile && $pdfFile->content) {
            $pdfContext = "PDF carregado: " . substr($pdfFile->content, 0, 1000) . "...\n\n";
        }

        // Chamar API DeepSeek
        $botResponse = $this->deepSeekService->sendMessage($pdfContext . $sanitizedMessage);

        // Salvar resposta do bot
        Message::create([
            'conversation_id' => $conversation->id,
            'content' => $botResponse,
            'sender' => 'bot',
        ]);

        return response()->json([
            'success' => true,
            'conversation_id' => $conversation->id,
            'bot_response' => $botResponse,
        ]);
    }

    public function uploadPdf(Request $request)
    {
        $request->validate([
            'pdf' => 'required|file|mimes:pdf|max:10240',
            'conversation_id' => 'nullable|exists:conversations,id',
        ]);

        // Criar ou obter conversa
        if ($request->conversation_id) {
            $conversation = Conversation::where('id', $request->conversation_id)
                ->where('user_id', auth()->id())
                ->firstOrFail();
        } else {
            $conversation = Conversation::create([
                'title' => 'Conversa com PDF',
                'user_id' => auth()->id(),
            ]);
        }

        // Processar PDF
        $file = $request->file('pdf');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('pdfs', $filename, 'public');

        // Extrair texto do PDF
        $pdfText = $this->extractPdfText(storage_path('app/public/' . $path));

        // Salvar informações do PDF
        $pdfFile = PdfFile::create([
            'conversation_id' => $conversation->id,
            'filename' => $filename,
            'original_name' => $file->getClientOriginalName(),
            'content' => $pdfText,
            'page_count' => $this->getPdfPageCount(storage_path('app/public/' . $path)),
        ]);

        return response()->json([
            'success' => true,
            'conversation_id' => $conversation->id,
            'pdf_content' => substr($pdfText, 0, 500) . '...',
            'page_count' => $pdfFile->page_count,
        ]);
    }

    private function extractPdfText($path)
    {
        try {
            $parser = new Parser();
            $pdf = $parser->parseFile($path);
            return $pdf->getText();
        } catch (\Exception $e) {
            return 'Erro ao extrair texto do PDF: ' . $e->getMessage();
        }
    }

    private function getPdfPageCount($path)
    {
        try {
            $parser = new Parser();
            $pdf = $parser->parseFile($path);
            return count($pdf->getPages());
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function deleteConversation($id)
    {
        $conversation = Conversation::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $conversation->delete();

        return response()->json(['success' => true]);
    }
}
