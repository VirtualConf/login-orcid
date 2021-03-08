<?php namespace ProcessWire;

/**
 * Configuration helper class for LoginOrcid module
 * 
 * CONFIG PROPERTIES (mirrored from LoginOrcid module): 
 * 
 * @property string $appID 
 * @property string $appSecret
 * @property bool|int $createUsers
 * @property int $afterLoginPageID
 * @property int $errorLoginPageID
 * @property int $commonUserName
 * @property string $userNameFormat
 * @property array $addRoles
 * @property array $disallowRoles
 * @property array $disallowPermissions
 *
 * @property string $pageName
 * @property string $templateName
 * @property string $fieldName
 * @property string $roleName
 * 
 */

class LoginOrcidConfigure extends WireData {
	
	/**
	 * Permissions that can be requested from LOrcid
	 *
	 * @var array
	 *
	 */

	
	protected $module;
	
	public function __construct(LoginOrcid $module) {
		$this->module = $module;
	}
	
	public function get($key) {
		return $this->module->get($key);
	}
	
	public function getInputfields(InputfieldWrapper $inputfields) {

		$modules = $this->wire('modules');
		
		// OAuth fieldset -----------------------------------------------------------------------

		$fieldset = $modules->get('InputfieldFieldset');
		$fieldset->label = $this->_('OAuth configuration for ORCID');
		$fieldset->icon = 'key';
		if($this->appID && $this->appSecret) $fieldset->collapsed = Inputfield::collapsedYes;
		$inputfields->add($fieldset);

		$f = $modules->get('InputfieldText');
		$f->attr('name', 'appID');
		$f->attr('value', $this->appID);
		$f->label = $this->_('Client ID');
		$f->description = $this->_('Client ID for your website, which you can obtain from [here](https://orcid.org/developer-tools).');
		$fieldset->add($f);

		$f = $modules->get('InputfieldText');
		$f->attr('name', 'appSecret');
		$f->attr('value', $this->appSecret);
		$f->label = $this->_('Client Secret');
		$f->description = $this->_('Client Secret for your website. Provided by Orcid after you have created your app. You need to add https://yourdomain.com/login-orcid/ as redirect URI');
		$fieldset->add($f);
		
		// Users, roles and access fieldset ----------------------------------------------------

		$fieldset = $modules->get('InputfieldFieldset');
		$fieldset->label = $this->_('Users, roles and access');
		$inputfields->add($fieldset);

		$f = $modules->get('InputfieldRadios');
		$f->attr('name', 'createUsers');
		$f->label = $this->_('How should ORCID user(s) be managed?');
		$f->icon = 'user';
		$f->addOption(1, $this->_('Create separate ProcessWire users for each Orcid user'));
		$f->addOption(0, $this->_('Make all Orcid users point to the same ProcessWire user'), array('disabled' => 'disabled'));
		$f->attr('value', $this->createUsers);
		$fieldset->add($f);

		$f = $modules->get('InputfieldAsmSelect');
		$f->attr('name', 'addRoles');
		$f->label = $this->_('Roles to add to users that have ORCID login');
		$addRoles = $this->addRoles;
		foreach($this->wire('roles') as $role) {
			if($role->name == 'superuser' || $role->name == 'guest') continue;
			$label = $role->name;
			if($role->name == $this->roleName) {
				if(!in_array($role->name, $addRoles)) $addRoles[] = $role->name;
				$label .= ' ' . $this->_('(required)');
			}
			$f->addOption($role->name, $label);
		}
		$f->collapsed = Inputfield::collapsedYes;
		$f->attr('value', $addRoles);
		$fieldset->add($f);

		$f = $modules->get('InputfieldAsmSelect');
		$f->attr('name', 'disallowRoles');
		$f->label = $this->_('Disallow ORCID login for roles');
		$f->description = $this->_('Prevent users with any selected roles from logging into ProcessWire with ORCID only.');
		$f->description .= ' ' . $this->_('ORCID data can still be used, but users having these roles can not login to their ProcessWire account from ORCID.');
		$f->notes = $this->_('We recommend preventing roles with admin access from using ORCID login, for added security.');
		foreach($this->wire('roles') as $role) {
			$f->addOption($role->name);
		}
		$f->attr('value', $this->disallowRoles);
		$f->collapsed = Inputfield::collapsedYes;
		$fieldset->add($f);

		$f = $modules->get('InputfieldAsmSelect');
		$f->attr('name', 'disallowPermissions');
		$f->label = $this->_('Disallow ORCID login for users having permissions');
		$f->description = $this->_('Prevent users with any selected permissions from logging into ProcessWire with ORCID only.');
		$f->description .= ' ' . $this->_('ORCID data can still be used, but users having these permissions cannot login to their ProcessWire account from ORCID.');
		$f->notes = $this->_('Selecting page-edit permission here is recommended, as it is the prerequisite to most admin related permissions.');
		foreach($this->wire('permissions') as $permission) {
			$f->addOption($permission->name);
		}
		$f->collapsed = Inputfield::collapsedYes;
		$f->attr('value', $this->disallowPermissions);
		$fieldset->add($f);
		
		return $inputfields;
	}
}
