<?php

if (!function_exists('formatMessage')) {
    function formatMessage($text)
    {
        if (!$text) return '';

        // Converter quebras de linha
        $formattedText = nl2br(e($text));

        // Detectar código entre ```
        $formattedText = preg_replace_callback('/```([\s\S]*?)```/', function($matches) {
            $code = htmlspecialchars(trim($matches[1]));
            return '<div class="code-block"><div class="code-header"><span>código</span><button class="copy-btn" onclick="copyCode(this)">Copiar</button></div><pre><code>' . $code . '</code></pre></div>';
        }, $formattedText);

        // Código inline entre `
        $formattedText = preg_replace('/`([^`]+)`/', '<code>$1</code>', $formattedText);

        return $formattedText;
    }
}
