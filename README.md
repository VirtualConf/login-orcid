# Login for ORCID 

- Module for ProcessWire 3.x (requires PW 3.0.42 or newer).
- Enables Orcid login/authentication for PW and use of Facebook data.
- Originally developed by Ryan Cramer, made for and sponsored by Michael Barón.
- Use orcid-php client by Sam Wilson/ modified by Kouchoanou Théophane  under MIT License


## How it works

This module creates a new page /login-orcid/.
When a user accesses this page, it asks them to login to Orcid. If they are already logged
in to Orcid, it will ask them to approve it. Upon approval, they are redirected back to your
site and now logged in to ProcessWire with a user having the role “login-orcid”. If the user
has not previously done this before, a new account will be created for them. The created account 
uses the name of their Orcid account and updates their affiliation (for this a field affiliation needs to exist).


## Installation

1. Unzip and copy the module’s files to /site/modules/LoginOrcid/.

2. Create a new app from Orcid developer site: <https://orcid.org/developer-tools>.
   You will need to obtain a Orcid client ID and App Secret. 

   You need to set the RedirectUri to `https://yourdomain/login-orcid/`
       

3. Configure the module in the ProcessWire admin (Modules > Site > Login Orcid). Add the 
  Orcid App ID and App Secret you obtained in the last step, to the indicated fields. 
   
4. If using the VCMS site profile add login-register as required role for the user
   
5. Now lets test things out. Log out of ProcessWire (if you are logged in). Then access the 
   /login-orcid/ URL on your website where the module is installed. It should redirect to
  Orcid and ask you to login, or ask you to approve the request if you are already logged in.
   Upon login/approval, Orcid will redirect to your designated page, a new user account will
   be created in ProcessWire (if not already created), and the user will be logged in. 


Care needs to be taken, that Orcid users may hide their email and it will not be accesible from the public API. 
   

