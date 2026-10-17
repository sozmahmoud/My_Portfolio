<?php
$file = 'c:/xampp/htdocs/LIORA/assets/css/styles.css';
$content = file_get_contents($file);

// Remove the corrupted spaced-out block
// It starts with ' / *   R e w a r d' and ends with ' } ' after the @media query
$pattern = '/ \/ \*   R e w a r d[\s\S]+?@ m e d i a   s c r e e n   a n d   \( m a x - w i d t h :   7 6 8 p x \)   \{ [\s\S]+?\}[\s\S]+?\}/u';

$newContent = preg_replace($pattern, '', $content);

// Also fix the accidental deletion of .reward-step h5 {
if (strpos($newContent, '.reward-step h5 {') === false) {
    $newContent = str_replace(".reward-step h5 {\n.checkout__fields", ".reward-step h5 {\n    font-size: var(--normal-font-size);\n    margin-bottom: 0.5rem;\n    color: var(--first-color);\n}\n\n.reward-step p {\n    font-size: var(--small-font-size);\n    color: var(--text-color);\n    line-height: 1.4;\n}\n\n@media screen and (max-width: 768px) {\n    .reward-explanation__grid {\n        grid-template-columns: 1fr;\n    }\n}\n\n.checkout__fields", $newContent);
}

file_put_contents($file, $newContent);
echo "✓ styles.css has been repaired and cleaned up!\n";
?>
