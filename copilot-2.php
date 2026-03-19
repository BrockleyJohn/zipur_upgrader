<?php
/**
 * GitHub-Style PHP Diff Viewer
 * - Reads two PHP files from disk
 * - Shows side-by-side diff with line numbers
 * - Syntax highlighting via Highlight.js
 * - Inline diff colors for added/removed text
 * Save as github_diff_viewer.php and open in browser.
 */

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
    <title>GitHub-Style PHP Diff Viewer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github.min.css">
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .diff-container { display: flex; gap: 20px; }
        .code-block { width: 50%; border: 1px solid #ddd; background: #fff; overflow-x: auto; }
        table { border-collapse: collapse; width: 100%; }
        td.line-num { width: 40px; background: #f6f8fa; color: #999; text-align: right; padding: 0 5px; border-right: 1px solid #ddd; }
        td.code { padding: 0 10px; white-space: pre; vertical-align: top; }
        ins { background-color: #e6ffed; text-decoration: none; }
        del { background-color: #ffeef0; text-decoration: none; }
        pre { margin: 0; }
        h2 { margin-bottom: 10px; }
        button { padding: 8px 12px; margin-bottom: 15px; cursor: pointer; }
    </style>
</head>
<body>

<h2>GitHub-Style PHP Diff Viewer</h2>
<button onclick="createDiff()">Generate Diff</button>

<div class="diff-container">
    <div class="code-block">
        <table id="oldTable"></table>
    </div>
    <div class="code-block">
        <table id="newTable"></table>
    </div>
</div>

<!-- Diff Match Patch JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/diff_match_patch/20121119/diff_match_patch.js"></script>
<!-- Highlight.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/languages/php.min.js"></script>
<script>
hljs.highlightAll();

function createDiff() {
    const oldCode = `<?= addslashes($oldCode) ?>`;
    const newCode = `<?= addslashes($newCode) ?>`;

    const dmp = new diff_match_patch();
    const diffOld = dmp.diff_main(oldCode, newCode);
    const diffNew = dmp.diff_main(newCode, oldCode);

    dmp.diff_cleanupSemantic(diffOld);
    dmp.diff_cleanupSemantic(diffNew);

    renderTable('oldTable', diffOld);
    renderTable('newTable', diffNew);

    hljs.highlightAll();
}

function renderTable(tableId, diff) {
    const table = document.getElementById(tableId);
    table.innerHTML = '';
    const lines = diff_prettyLines(diff);

    lines.forEach((line, index) => {
        const tr = document.createElement('tr');

        const tdNum = document.createElement('td');
        tdNum.className = 'line-num';
        tdNum.textContent = index + 1;

        const tdCode = document.createElement('td');
        tdCode.className = 'code';
        tdCode.innerHTML = `<pre><code class="php">${line}</code></pre>`;

        tr.appendChild(tdNum);
        tr.appendChild(tdCode);
        table.appendChild(tr);
    });
}

function diff_prettyLines(diff) {
    const html = [];
    diff.forEach(part => {
        let text = part[1].replace(/</g, "&lt;").replace(/>/g, "&gt;");
        if (part[0] === 1) { // Added
            text = `<ins>${text}</ins>`;
        } else if (part[0] === -1) { // Removed
            text = `<del>${text}</del>`;
        }
        html.push(text);
    });
    return html.join('').split("\n");
}
</script>

</body>
</html>
