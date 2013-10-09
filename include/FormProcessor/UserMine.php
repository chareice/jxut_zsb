<?php
     class FormProcessor_UserMine extends FormProcessor
     {
        protected $db = null;
        public $user = null;
        
         public function __construct($db, $user_id)
        {
            parent::__construct();

            $this->db = $db;
            $this->user = new DatabaseObject_User($db);
            $this->user->load($user_id);

            $this->realname = $this->user->profile->realname;

        }
       public function process(Zend_Controller_Request_Abstract $request)
        {
         
         /*  $this->first_name = $this->sanitize($request->getPost('first_name'));
         
         if (strlen($this->password) > 0 || strlen($this->password_confirm) > 0) {
                if (strlen($this->password) == 0)
                    $this->addError('password', 'Please enter the new password');
                else if (strlen($this->password_confirm) == 0)
                    $this->addError('password_confirm', 'Please confirm your new password');
                else if ($this->password != $this->password_confirm)
                    $this->addError('password_confirm', 'Please retype your password');
                else
                    $this->user->password = $this->password;
            }*/
        }
     }
?>
