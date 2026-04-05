---------------------------------------------------

Zipur CE Phoenix Upgrade Utility - Version 2

---------------------------------------------------

Released under the GNU General Public License
Copyright (c) 2026: John Ferguson - @BrockleyJohn - SE Websites
Copyright (c) 2020: Preston Lord - @zipurman - Intricate Networks Inc.

  Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

  1. Re-distributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.

  2. Re-distributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.

  3. Neither the name of the copyright holder nor the names of its contributors may be used to endorse or promote products derived from this software without specific prior written permission.

  THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

---------------------------------------------------

This utility will upgrade your CE Phoenix store. 
The update data for each version is no longer included in the addon but downloaded automatically as required, so you don't need to upload a whole bunch in one go, or update the addon for each release.
After a new version of CE Phoenix is released, keep an eye on the support forum for this addon for announcement of the availability of the corresponding update.

Instructions:

    1. BACKUP YOUR STORE FILES AND YOUR DATABASE !!
    2. Copy the upgrader folder to somewhere on your server. The easiest location would be inside your catalog folder.
    3. Navigate to yourwebsite.com/upgrader/
    4. Create a password
    5. Login
    6. Link to the file structure of your store
    7. Test the connection
    8. Review core changes. This will download a clean version of the version you are running currently. It will then compare that to your installed version and let you know which files have been altered from their original state. 
    - a diff viewer is provided to show you the changes from the core file
    - a worklist is provided for you to store notes about the changes and any planned actions
    - YOU SHOULD REVIEW ALL OF THOSE CHANGES if any as they may break custom mods you have done to your store. After proceeding, during the upgrade(s), files will be tagged if they are replacing modified files ... again, review your core changes to be sure you dont break your store. Think about whether changes can be made in advance or if you need to follow up quickly afterwards.
    9. Check for configuration duplicates and remove any found.
    10. Review the update:
    - the actions the update will take are displayed
    - pay close attention to the files that will be replaced; you can access your worklist entries here
    - if necessary you can return to the core compare step to redisplay differences and make better notes of any followup actions
    11. Start upgrading and read the upgrade results carefully.
    - copies are made of any updated files that had changes from core
    12. After the upgrade is complete, the updater circles around to the next available update and you can plough straight on with comparing to core again. Your work list is kept.

    Happy Upgrading!!

    BrockleyJohn


