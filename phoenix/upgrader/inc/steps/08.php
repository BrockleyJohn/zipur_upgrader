<?php

    /*

 Name: Zipur CE Phoenix Upgrade Utility

 Author: Preston Lord
 	 phoenixaddons.com / @zipurman / plord@inetx.ca

 Released under the GNU General Public License

 Copyright (c) 2021: Preston Lord - @zipurman - Intricate Networks Inc.

  Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

  1. Re-distributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.

  2. Re-distributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.

  3. Neither the name of the copyright holder nor the names of its contributors may be used to endorse or promote products derived from this software without specific prior written permission.

  THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

*/

    if ( ! empty( $inc_directory ) ) {

        $this_step_file = str_replace( '.php', '', basename( __FILE__ ) );

        if ( $require_step == $this_step_file || empty( $require_step ) ) {
            ?>

            <div class="w-75 m-auto">
                <p><?php echo TEXT_STEP_08_DESCRIPTION; ?></p>

                <?php

                    $okset = 1;

                    zipDeleteDirectory( 'inc/clean_core/');

                    //check core files
                    if ( ! file_exists( 'inc/clean_core/' . $cep_version ) ) {

                        if ( ! file_exists( 'inc/clean_core' ) ) {
                            if ( ! mkdir( 'inc/clean_core', 0700 ) ) {
                                echo '<span class="text-danger">' . TEXT_DIRECTORY_CREATE_ERROR . '</span>';
                                $okset = 0;
                            }
                        }

                        $extracted_folder = 'inc/clean_core/';

                        if ( ! empty( $okset ) ) {
                            $ziparch = class_exists('ZipArchive');

                            if ( version_compare( '1.0.8.0', trim( $cep_version ) ) <= 0 /*|| version_compare( '1.1.0.0', trim( $cep_version ) ) >= 0*/ ) {
                                //$newurl      = 'https://codeload.github.com/CE-PhoenixCart/PhoenixCart/zip/' . trim( $cep_version );
                                $newurl      = 'https://api.github.com/repos/CE-PhoenixCart/PhoenixCart/zipball/v' . trim( $cep_version );
                                $versionpath = 'CE-PhoenixCart-PhoenixCart-';

                            } else {
                                $newurl      = 'https://codeload.github.com/gburton/CE-Phoenix/zip/' . trim( $cep_version );
                                $versionpath = 'CE-Phoenix-';

                            }

                            $zipext = $ziparch ? '.zip' : '.tar.gz';
                            $newpath = 'inc/clean_core/' . trim( $cep_version ) . $zipext;
                            $fp      = fopen( $newpath, 'w+' );
                            $ch      = curl_init();
                            curl_setopt( $ch, CURLOPT_URL, $newurl );
                            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, false );
                            curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
                            curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
                            curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 10 );
                            curl_setopt( $ch, CURLOPT_USERAGENT, 'PhoenixUpgrader/' . $zipFileVersion );
                            curl_setopt( $ch, CURLOPT_FILE, $fp );
                            curl_exec( $ch );
                            $info = curl_getinfo($ch);
                            curl_close( $ch );
                            fclose( $fp );
                            error_log('Download info: ' . print_r($info, true));

                            if ( $info['http_code'] !== 200 && $info['http_code'] !== 302 || ! file_exists( $newpath ) ) {
                                echo '<span class="text-danger">' . ZIPUR_CODE_COMPARE_DOWNLOAD_ERROR . ' (' . $versionpath . trim( $cep_version ) . $zipext . ')</span>';
                                $okset = 0;
                            } else {
                                echo '<span class="text-success">' . ZIPUR_CODE_COMPARE_DOWNLOAD_SUCCESS . ' (' . $versionpath . trim( $cep_version ) . $zipext . ')</span>';
                                if ($ziparch) {
                                    $zip = new ZipArchive;
                                    $res = $zip->open( $newpath );
                                    if ( $res === true ) {
                                        $zip->extractTo( 'inc/clean_core/' );
                                        $zip->close();
                                        echo '<br/><span class="text-success">' . ZIPUR_CODE_COMPARE_UNZIP_SUCCESS . '</span>';
                                        unlink( $newpath );//deletes downloaded zip
                                    } else {
                                        echo '<br/><span class="text-danger">' . ZIPUR_CODE_COMPARE_UNZIP_FAILED . ' (' . $newpath . ')</span>';
                                        $okset = 0;
                                    }
                                } else {
                                    $gz_extract = new PharData( $newpath );
                                    $gz_extract->decompress(); // creates files.tar
                                    $tar_extract = new PharData( str_replace( '.gz', '', $newpath ) );
                                    $tar_extract->extractTo( 'inc/clean_core/' );
                                    unlink( str_replace( '.gz', '', $newpath ) );//deletes tar
                                    unlink( $newpath );//deletes downloaded zip
                                    echo '<br/><span class="text-success">' . ZIPUR_CODE_COMPARE_UNZIP_SUCCESS . '</span>';
                                }

                                // lets get the actual folder name that was extracted (when using github api the folder name is not consistent so we need to find it)
                                $files = scandir('inc/clean_core/');
                                foreach ($files as $file) {
                                    if (is_dir('inc/clean_core/' . $file) && strpos($file, $versionpath) === 0) {
                                        $extracted_folder = 'inc/clean_core/' . $file;
                                        break;
                                    }
                                }
                                error_log('Extracted folder: ' . $extracted_folder);
                            }
                        }

                        $installedfiles    = [];
                        $cleancorefiles    = [];
                        $zip_added_files   = [];
                        $zip_altered_files = [];

                        //Start compare
                        $exclude1 = [
                            'images',
                            'imported',
                            'updates',
                            'old',
                            'install',
                            'clean_core',
                            'upgrader',
                            '.github/',
                            'zcache',
                            'xdebug',
                            'README',
                            'README.md',
                        ];

                        //setup array for existing install
                        zipGetCoreArray( $config['cep_files']['root'], $exclude1 );
                        error_log('installed files: ' . print_r($installedfiles, true));

                        $exclude2 = [
                            'images',
                            'imported',
                            'updates',
                            'old',
                            'clean_core',
                            'upgrader',
                            '.github/',
                            'zcache',
                            'xdebug',
                            'README',
                            'README.md',
                        ];

                        //setup array for clean core (same version)
                        //zipGetCoreArray( 'inc/clean_core/' . $versionpath . trim( $cep_version ), $exclude2, 1 );
                        zipGetCoreArray( $extracted_folder, $exclude2, 1 );

                        error_log('clean core files: ' . print_r($cleancorefiles, true));

                        foreach ( $installedfiles as $installedfilekey => $installedfile ) {
                            if ( empty( $cleancorefiles[ $installedfilekey ] ) ) {
                                $zip_added_files[] = $installedfilekey;
                            } else if ( $cleancorefiles[ $installedfilekey ] != $installedfile ) {
                                $zip_altered_files[] = $installedfilekey;
                            }
                        }
                        zipAlert( TEXT_STEP_08_WARNING, 'success' );

                        echo '<ul class="list-group">';

                        $b = 0;
                        foreach ( $zip_altered_files as $zip_added_file ) {

                            echo '<li class="list-group-item align-items-center justify-content-between d-flex py-1">' . $zip_added_file . ' ' . zipButton(TEXT_BUTTON_DIFFS, 'secondary btn-diff', '#', 'fa-compress-alt', 'md', 'diffs' . $b, ['filename' => $zip_added_file, 'corepath' => $extracted_folder]) . '</li>';
                            $b++;

                        }
                        if ( $b == 0 ) {
                            echo '<li class="list-group-item">' . TEXT_STEP_08_NO_ALTERED_FILES . '</li>';
                        }
                        echo '</ul>';

                        $config['core_changed_files'] = $zip_altered_files;
                        $config['core_added_files'] = $zip_added_files;
                        $config['next_version'] = $next_version;
                        $save_changes        = 1;

                    }

                    if ( $okset == 1 ) {
                        $save_changes        = 1;
                        $config['limitstep'] = ( $config['limitstep'] < 8 ) ? 8 : $config['limitstep'];
                    }

                ?>

                <div class="navbar-light bg-light text-right">
                    <?php
                        /** @var int $laststep */
                        echo zipButton( TEXT_BUTTON_BACK, 'secondary', 'index.php?step=3', 'fa-chevron-left', 'sm' );
                        echo zipButton( TEXT_BUTTON_NEXT, 'success', 'index.php?step=3', 'fa-chevron-right', 'sm' );
                    ?>
                </div>
            </div>
<script>
let oldCode = '', newCode = '';
</script>
<div class="modal" tabindex="-1" id="diffModal">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="diffModalTitle"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" data-dismiss="modal" aria-label="<?= TEXT_CLOSE ?>"> X </button>
      </div>
      <div class="modal-body" id="modalBody">
        <div class="text-center mb-3">
            <span class="badge bg-secondary text-white"><?= TEXT_STEP_08_DIFFS_INSTRUCTIONS ?></span>
        </div>
        <div class="diff-container">
            <div class="code-block"><pre><code id="oldOutput" class="php"></code></pre></div>
            <div class="code-block"><pre><code id="newOutput" class="php"></code></pre></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-dismiss="modal"><?= TEXT_CLOSE ?></button>
      </div>
    </div>
  </div>
</div>

<!-- Diff Match Patch JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/diff_match_patch/20121119/diff_match_patch.js"></script>
<!-- Highlight.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/languages/php.min.js"></script>
<script>
// plugin so we can escape HTML in the code blocks but still have the diff highlights work correctly (by merging the original HTML with the highlighted HTML)
var mergeHTMLPlugin = (function () {
  'use strict';

  var originalStream;

  /**
   * @param {string} value
   * @returns {string}
   */
  function escapeHTML(value) {
    return value
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#x27;');
  }

  /* plugin itself */

  /** @type {HLJSPlugin} */
  const mergeHTMLPlugin = {
    // preserve the original HTML token stream
    "before:highlightElement": ({ el }) => {
      originalStream = nodeStream(el);
    },
    // merge it afterwards with the highlighted token stream
    "after:highlightElement": ({ el, result, text }) => {
      if (!originalStream.length) return;

      const resultNode = document.createElement('div');
      resultNode.innerHTML = result.value;
      result.value = mergeStreams(originalStream, nodeStream(resultNode), text);
      el.innerHTML = result.value;
    }
  };

  /* Stream merging support functions */

  /**
   * @typedef Event
   * @property {'start'|'stop'} event
   * @property {number} offset
   * @property {Node} node
   */

  /**
   * @param {Node} node
   */
  function tag(node) {
    return node.nodeName.toLowerCase();
  }

  /**
   * @param {Node} node
   */
  function nodeStream(node) {
    /** @type Event[] */
    const result = [];
    (function _nodeStream(node, offset) {
      for (let child = node.firstChild; child; child = child.nextSibling) {
        if (child.nodeType === 3) {
          offset += child.nodeValue.length;
        } else if (child.nodeType === 1) {
          result.push({
            event: 'start',
            offset: offset,
            node: child
          });
          offset = _nodeStream(child, offset);
          // Prevent void elements from having an end tag that would actually
          // double them in the output. There are more void elements in HTML
          // but we list only those realistically expected in code display.
          if (!tag(child).match(/br|hr|img|input/)) {
            result.push({
              event: 'stop',
              offset: offset,
              node: child
            });
          }
        }
      }
      return offset;
    })(node, 0);
    return result;
  }

  /**
   * @param {any} original - the original stream
   * @param {any} highlighted - stream of the highlighted source
   * @param {string} value - the original source itself
   */
  function mergeStreams(original, highlighted, value) {
    let processed = 0;
    let result = '';
    const nodeStack = [];

    function selectStream() {
      if (!original.length || !highlighted.length) {
        return original.length ? original : highlighted;
      }
      if (original[0].offset !== highlighted[0].offset) {
        return (original[0].offset < highlighted[0].offset) ? original : highlighted;
      }

      /*
      To avoid starting the stream just before it should stop the order is
      ensured that original always starts first and closes last:

      if (event1 == 'start' && event2 == 'start')
        return original;
      if (event1 == 'start' && event2 == 'stop')
        return highlighted;
      if (event1 == 'stop' && event2 == 'start')
        return original;
      if (event1 == 'stop' && event2 == 'stop')
        return highlighted;

      ... which is collapsed to:
      */
      return highlighted[0].event === 'start' ? original : highlighted;
    }

    /**
     * @param {Node} node
     */
    function open(node) {
      /** @param {Attr} attr */
      function attributeString(attr) {
        return ' ' + attr.nodeName + '="' + escapeHTML(attr.value) + '"';
      }
      // @ts-ignore
      result += '<' + tag(node) + [].map.call(node.attributes, attributeString).join('') + '>';
    }

    /**
     * @param {Node} node
     */
    function close(node) {
      result += '</' + tag(node) + '>';
    }

    /**
     * @param {Event} event
     */
    function render(event) {
      (event.event === 'start' ? open : close)(event.node);
    }

    while (original.length || highlighted.length) {
      let stream = selectStream();
      result += escapeHTML(value.substring(processed, stream[0].offset));
      processed = stream[0].offset;
      if (stream === original) {
        /*
        On any opening or closing tag of the original markup we first close
        the entire highlighted node stack, then render the original tag along
        with all the following original tags at the same offset and then
        reopen all the tags on the highlighted stack.
        */
        nodeStack.reverse().forEach(close);
        do {
          render(stream.splice(0, 1)[0]);
          stream = selectStream();
        } while (stream === original && stream.length && stream[0].offset === processed);
        nodeStack.reverse().forEach(open);
      } else {
        if (stream[0].event === 'start') {
          nodeStack.push(stream[0].node);
        } else {
          nodeStack.pop();
        }
        render(stream.splice(0, 1)[0]);
      }
    }
    return result + escapeHTML(value.substr(processed));
  }

  return mergeHTMLPlugin;

}());
    // add plugin to highlight.js
    hljs.addPlugin(mergeHTMLPlugin);
    
    document.querySelectorAll('.btn-diff').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const filename = this.getAttribute('data-filename');
            const corepath = this.getAttribute('data-corepath');
            //fetch(`diff.php?file=${encodeURIComponent(filename)}`)
            fetch(`diff.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `file=${encodeURIComponent(filename)}&corepath=${encodeURIComponent(corepath)}`,
            })
                .then(response => response.text())
                .then(diffHtml => {
                    document.getElementById('diffModalTitle').textContent = `${filename}`;
                    let script = document.createElement('script');
                    script.textContent = diffHtml;
                    document.getElementById('modalBody').appendChild(script);
                    new bootstrap.Modal(document.getElementById('diffModal')).show();
                    createDiff();
                })
                .catch(error => {
                    document.getElementById('diffModalTitle').textContent = 'Error';
                    document.getElementById('modalBody').textContent = 'Could not load diff: ' + error;
                    new bootstrap.Modal(document.getElementById('diffModal')).show();
                });
        });
    });

function createDiff() {
    const dmp = new diff_match_patch();
    const diffOld = dmp.diff_main(oldCode, newCode);
    const diffNew = dmp.diff_main(newCode, oldCode);

    dmp.diff_cleanupSemantic(diffOld);
    dmp.diff_cleanupSemantic(diffNew);

    // Convert to HTML with inline highlights
    document.getElementById('oldOutput').innerHTML = dmp.diff_prettyHtml(diffOld);
    document.getElementById('newOutput').innerHTML = dmp.diff_prettyHtml(diffNew);

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

            <?php
        }
    }