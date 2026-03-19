<?php
/**
 * Interactive Side-by-Side PHP Diff Viewer
 * - Uses Google Diff Match Patch (JS) for inline differences
 * - Uses Highlight.js for PHP syntax highlighting
 * - Editable text areas for quick comparisons
 * Save as diff_viewer.php and open in browser.
 */

// Example old and new code (replace with file_get_contents() for real files)
/* $oldCode = <<<CODE
<?php
echo "Hello World";
echo "This is old code";
?>
CODE;

$newCode = <<<CODE
<?php
echo "Hello World!";
echo "This is new code with extra text";
?>
CODE; */
// File paths (change to your files)
$file1 = __DIR__ . '/inc/clean_core/PhoenixCart-1.0.9.9/includes/languages/english/modules/content/footer_suffix/cm_footer_extra_copyright.php';
$file2 = '/home/sites/14a/c/c3842bd4d7/alfa/includes/languages/english/modules/content/footer_suffix/cm_footer_extra_copyright.php';

// Read file contents safely
$oldCode = file_exists($file1) ? file_get_contents($file1) : "<?php\n// Old file not found\n";
$newCode = file_exists($file2) ? file_get_contents($file2) : "<?php\n// New file not found\n";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Interactive PHP Diff Viewer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github.min.css">
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { display: flex; gap: 20px; }
        textarea { width: 100%; height: 200px; font-family: monospace; }
        .code-block { width: 50%; border: 1px solid #ccc; background: #fafafa; overflow-x: auto; padding: 10px; }
        ins { background-color: #e6ffe6; text-decoration: none; }
        del { background-color: #ffe6e6; text-decoration: none; }
        button { padding: 8px 12px; margin: 15px 0; cursor: pointer; }
        pre { margin: 0; }
        h3 { margin-bottom: 5px; }
    </style>
</head>
<body>

<h2>Interactive Side-by-Side PHP Diff Viewer</h2>

<div class="container">
    <div>
        <h3>Old Code</h3>
        <textarea id="text1"><?= htmlspecialchars($oldCode) ?></textarea>
    </div>
    <div>
        <h3>New Code</h3>
        <textarea id="text2"><?= htmlspecialchars($newCode) ?></textarea>
    </div>
</div>

<button onclick="createDiff()">Show Diff</button>

<h3>Diff Result:</h3>
<div class="container">
    <div class="code-block"><pre><code id="oldOutput" class="php"></code></pre></div>
    <div class="code-block"><pre><code id="newOutput" class="php"></code></pre></div>
</div>

<!-- Diff Match Patch JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/diff_match_patch/20121119/diff_match_patch.js"></script>
<!-- Highlight.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/languages/php.min.js"></script>
<script>
hljs.highlightAll();

function createDiff() {
    const dmp = new diff_match_patch();
    const text1 = document.getElementById('text1').value;
    const text2 = document.getElementById('text2').value;

    // Create diffs for each version separately
    const diffOld = dmp.diff_main(text1, text2);
    const diffNew = dmp.diff_main(text2, text1);

    dmp.diff_cleanupSemantic(diffOld);
    dmp.diff_cleanupSemantic(diffNew);

    // Convert to HTML with inline highlights
    document.getElementById('oldOutput').innerHTML = dmp.diff_prettyHtml(diffOld);
    document.getElementById('newOutput').innerHTML = dmp.diff_prettyHtml(diffNew);

    // Re-highlight syntax
    hljs.highlightAll();
}
</script>

</body>
</html>
