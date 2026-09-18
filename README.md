# Upgrader Utility for CE Phoenix

## Installation Instructions


## User Guide: Managing Core Changes & Updates

### A step-by-step user guide for website owners updating their CE PhoenixCart store using the Zipur Upgrade Utility, focusing on Step 08 to track core modifications.

When updating CE PhoenixCart, custom modifications to frontend files can often be safely placed in your template override directory (templates/override/). However, changes to backend admin files (admin/) or core engine files cannot be handled via template overrides.
Use this simple workflow in Step 08 of the Zipur Upgrade Utility to audit, track, and re-apply these core changes during an update.
Step-by-Step Update Workflow
1. Run the Automatic File Audit
● Open the Zipur Upgrade Utility and navigate to Step 08.
● The tool automatically downloads a clean copy of your current core release and scans your site files against it.
● Any modified core files—such as custom changes in admin/orders.php or core system utilities—will appear in the altered files list.
2. Inspect Your Custom Code
● Click the Diffs button next to any flagged file.
● A code window will pop up showing an exact comparison between the clean core file and your customized file:
○ Green highlights (<ins>): Custom code lines you added.
○ Red highlights (<del>): Default core lines you removed.
3. Log Notes in the Worklist
● Scroll down to the Worklist Entry form located inside the diff modal.
● Type a quick summary explaining why the file was edited (e.g., "Added custom tracking field to admin order details page" or "Injected custom hook call").
● Click Add/Edit Entry.
● The utility saves your note to worklist.json and marks the file status badge as TO DO.
4. Apply Core Updates & Re-Apply Logic
● Proceed with the core software update steps.
● Return to Step 08 to review your saved worklist notes.
● Open the file diff modal, grab your saved snippets from the notes area, and re-apply them to the updated files.
● Click Mark Complete to change the file badge to DONE.
Quick Rules for Customizations
● Frontend Layouts & Texts: Copy files to templates/override/ whenever possible to protect them from future software updates.
● Admin & Core Logic: Make edits directly in the file, then immediately register them in Step 08 using the Worklist form.