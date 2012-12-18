<?php
	require_once($CFG->libdir.'/formslib.php');
class mod_myforum_editpost_form extends moodleform {
	function definition() {
		global $CFG;
		
		$mform    =& $this->_form;
		$course        			= $this->_customdata['course'];
        $cm            			= $this->_customdata['cm'];
        $coursecontext 			= $this->_customdata['coursecontext'];
        $modcontext    			= $this->_customdata['modcontext'];
        $forum         			= $this->_customdata['forum'];
        $post          			= $this->_customdata['post']; // hack alert
		$name_message          	= $this->_customdata['name_message']; // hack alert
		
        
		$this->set_upload_manager(new upload_manager('attachment', true, false, $course, false, $forum->maxbytes, true, true));
		$mform->addElement('header', 'general', 'Editar');//fill in the data depending on page params
				
		$mform->addElement('text', 'e_subject', get_string('subject', 'forum'), 'size="48"');
        $mform->setType('e_subject', PARAM_TEXT);
        /*$mform->addRule('e_subject'.$name_message, get_string('required'), 'required', null, 'client');*/
        $mform->addRule('e_subject', get_string('maximumchars', '', 255), 'maxlength', 255, 'client'); 
		
		$mform->addElement('htmleditor', 'e_message', 'Sua resposta');
        $mform->setType('e_message', PARAM_RAW);
       /* $mform->addRule('e_message'.$name_message, '', 'required', null, 'client');*/
		
		if ($forum->maxbytes != 1 && has_capability('mod/forum:createattachment', $modcontext))  {  //  1 = No attachments at all
            $mform->addElement('file', 'attachment', get_string('attachment', 'forum'));
            $mform->setHelpButton('attachment', array('attachment', get_string('attachment', 'forum'), 'myforum'));
        }
		
		/****************BOTOES E PARAMETROS************************/
		$mform->addElement('hidden', 'acc');
        $mform->setType('acc', PARAM_TEXT);
		
		$mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
		
		$mform->addElement('hidden', 'idpost');
        $mform->setType('idpost', PARAM_INT);
		
		$mform->addElement('hidden', 'userid');
        $mform->setType('userid', PARAM_INT);
		
		$mform->addElement('hidden', 'reply');
        $mform->setType('reply', PARAM_INT);
		
		$mform->addElement('hidden', 'discussion');
        $mform->setType('discussion', PARAM_INT);
		
        $this->add_action_buttons(false, "Confirmar");
	}
	function validation($data, $files) {
        $errors = parent::validation($data, $files);
        if (($data['timeend']!=0) && ($data['timestart']!=0)
            && $data['timeend'] <= $data['timestart']) {
                $errors['timeend'] = get_string('timestartenderror', 'myforum');
            }
        return $errors;
    }
}
?>