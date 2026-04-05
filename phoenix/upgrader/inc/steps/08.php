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

                        $versionpath = 'CE-Phoenix';

                        // lets get the actual folder name that was extracted (when using github api the folder name is not consistent so we need to find it)
                        $files = scandir('inc/clean_core/');
                        foreach ($files as $file) {
                            if (is_dir('inc/clean_core/' . $file) && strpos($file, $versionpath) === 0) {
                                $extracted_folder = 'inc/clean_core/' . $file;
                                break;
                            }
                        }
                        //error_log('Extracted folder: ' . $extracted_folder);

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
                        //error_log('installed files: ' . print_r($installedfiles, true));

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

                        //error_log('clean core files: ' . print_r($cleancorefiles, true));

                        foreach ( $installedfiles as $installedfilekey => $installedfile ) {
                            if ( empty( $cleancorefiles[ $installedfilekey ] ) ) {
                                $zip_added_files[] = $installedfilekey;
                            } else if ( $cleancorefiles[ $installedfilekey ] != $installedfile ) {
                                $zip_altered_files[] = $installedfilekey;
                            }
                        }
                        zipAlert( TEXT_STEP_08_WARNING, 'success' );
                        $db = mysqli_connect( DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE, MYSQL_PORT );
                        $template_q = mysqli_query( $db, "SELECT `configuration_value` FROM `configuration` WHERE `configuration_key` = 'TEMPLATE_SELECTION'" );
                        $template = mysqli_fetch_assoc( $template_q );
                        zipAlert( sprintf(TEXT_STEP_08_CURRENT_TEMPLATE, $template['configuration_value']), 'info' );

                        echo '<ul class="list-group">';

                        $worklist = file_exists( $inc_directory . '/worklist.json' ) ? json_decode( file_get_contents( $inc_directory . '/worklist.json' ), true ) : [];

                        $b = 0;
                        foreach ( $zip_altered_files as $zip_added_file ) {

                          switch (true) {
                            case ! isset($worklist["{$zip_added_file}"]):
                              $worklist_style = TEXT_WORKLIST_NEW;
                              break;
                            case ($worklist[$zip_added_file]['status'] ?? '') === 'complete':
                              $worklist_style = TEXT_WORKLIST_DONE;
                              break;
                            default:
                              $worklist_style = TEXT_WORKLIST_TO_DO;
                          }

                            echo '<li class="list-group-item align-items-center justify-content-between d-flex py-1">' . $zip_added_file . ' <span>' . zipButton(TEXT_BUTTON_DIFFS, 'secondary btn-diff', '#', 'fa-compress-alt', 'md', 'diffs' . $b, ['filename' => $zip_added_file, 'corepath' => $extracted_folder, 'index' => $b]) . ' <i id="worklist_' . $b . '" class="' . $worklist_style . '"></i></span></li>';
                            $b++;

                        }
                        if ( $b == 0 ) {
                            echo '<li class="list-group-item">' . TEXT_STEP_08_NO_ALTERED_FILES . '</li>';
                        }
                        echo '</ul>';

                        $save_changes = 1;
                        $config['core_changed_files'] = $zip_altered_files;
                        $config['core_added_files'] = $zip_added_files;
                        $config['next_version'] = $next_version;
                        $config['limitstep'] = ( $config['limitstep'] < 8 ) ? 8 : $config['limitstep'];

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
        </div>
        <div class="text-center mt-3">
          <form id="worklistForm" style="display: inline-block; width:100%;">
            <span class=""><?= TEXT_STEP_08_DIFFS_WORKLIST_ENTRY ?> <i id="worklistEntryStatus" class=""></i></span>
            <?= zipField( 'textarea', 'worklist_entry', '', [], 'form-control', 'worklist_entry' ) ?>
            <div id="worklistButtons" class="mt-2">
            </div>
          </form>
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

    let diffModal;
    
    // assign modal once bootstrap is loaded
    document.addEventListener('DOMContentLoaded', function() {
      diffModal = new bootstrap.Modal(document.getElementById('diffModal'));
    });

    document.querySelectorAll('.btn-diff').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const filename = this.getAttribute('data-filename');
            const corepath = this.getAttribute('data-corepath');
            const index = this.getAttribute('data-index');
            // check for existing worklist entry for this file
            fetch(`worklist.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=load&file=${encodeURIComponent(filename)}&index=${encodeURIComponent(index)}`,
            })
                .then(response => response.json())
                .then(data => {
                    const worklistEntry = data.entry || '';
                    document.getElementById('worklist_entry').value = worklistEntry;
                    const buttonsDiv = document.getElementById('worklistButtons');
                    buttonsDiv.innerHTML = data.buttons;
                    if (data.entrystatus) {
                        const statusBadge = document.getElementById('worklistEntryStatus');
                        if (data.entrystatus === 'complete') {
                            statusBadge.className = '<?= TEXT_WORKLIST_DONE ?>';
                        } else if (data.entrystatus === 'todo') {
                            statusBadge.className = '<?= TEXT_WORKLIST_TO_DO ?>';
                        } else {
                            statusBadge.className = '';
                        }
                    }
                })
                .catch(error => {
                    console.error('Error loading worklist entry:', error);
                    document.getElementById('worklist_entry').value = '';
                    document.getElementById('worklistButtons').innerHTML = '';
                });
            // generate diffs
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
                    diffModal.show();
                    createDiff();
                })
                .catch(error => {
                    document.getElementById('diffModalTitle').textContent = 'Error';
                    document.getElementById('modalBody').textContent = 'Could not load diff: ' + error;
                    diffModal.show();
                });
        });
    });

    // bubbling click handler on form for worklist buttons (add/edit/remove)
    const worklistForm = document.getElementById('worklistForm');
    worklistForm.addEventListener('click', function(e) {
      if (e.target && e.target.matches('.listentry')) {
          const action = e.target.getAttribute('data-action');
          const filename = e.target.getAttribute('data-file');
          const index = e.target.getAttribute('data-index');
          // handle the action (add/edit/remove) for the worklist entry
          fetch(`worklist.php`, {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/x-www-form-urlencoded',
              },
              body: `action=${encodeURIComponent(action)}&file=${encodeURIComponent(filename)}&index=${encodeURIComponent(index)}&worklist_entry=${encodeURIComponent(document.getElementById('worklist_entry').value)}`,
          })                
              .then(response => response.json())
              .then(data => {
                // add some positive feedback
                if (data.success) {
                    //alert('Worklist updated successfully');
                    diffModal.hide();
                    if (data.entrystatus) {
                      const statusBadge = document.getElementById(`worklist_${index}`);
                      if (data.entrystatus === 'complete') {
                          statusBadge.className = '<?= TEXT_WORKLIST_DONE ?>';
                      } else if (data.entrystatus === 'todo') {
                          statusBadge.className = '<?= TEXT_WORKLIST_TO_DO ?>';
                      } else {
                          statusBadge.className = '';
                      }
                    }
                } else if (data.error) {
                    alert('Error: ' + data.error);
                }
              })
              .catch(error => {
                  console.error('Error updating worklist entry:', error);
                  // add some error feedback
                  alert('Error updating worklist entry: ' + error);
              });
      }

    });
    worklistForm.addEventListener('submit', function(e) {
        e.preventDefault();
    });

function createDiff() {
    const dmp = new diff_match_patch();
    const diffOld = dmp.diff_main(oldCode, newCode);
    //const diffNew = dmp.diff_main(newCode, oldCode);

    dmp.diff_cleanupSemantic(diffOld);
    //dmp.diff_cleanupSemantic(diffNew);

    // Convert to HTML with inline highlights
    document.getElementById('oldOutput').innerHTML = dmp.diff_prettyHtml(diffOld);
    //document.getElementById('newOutput').innerHTML = dmp.diff_prettyHtml(diffNew);

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