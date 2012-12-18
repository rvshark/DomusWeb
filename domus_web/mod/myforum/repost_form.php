<?php
	require_once($CFG->libdir.'/formslib.php');
class mod_myforum_repost_form extends moodleform {
	function definition() {
		global $CFG;
        
		$mform    				=& $this->_form;
		$course        			= $this->_customdata['course'];
        $cm            			= $this->_customdata['cm'];
        $coursecontext 			= $this->_customdata['coursecontext'];
        $modcontext    			= $this->_customdata['modcontext'];
        $forum         			= $this->_customdata['forum'];
        $post          			= $this->_customdata['post']; // hack alert
        $name_message          	= $this->_customdata['name_message']; // hack alert
		
		// the upload manager is used directly in post precessing, moodleform::save_files() is not used yet
        $this->set_upload_manager(new upload_manager('attachment', true, false, $course, false, $forum->maxbytes, true, true));
		$mform->addElement('header', 'general', 'Responder');//fill in the data depending on page params
		
		$mform->addElement('text', 'subject', get_string('subject', 'forum'), 'size="48"');
        $mform->setType('subject', PARAM_TEXT);
        /*$mform->addRule('subject', get_string('required'), 'required', null, 'client');*/
        $mform->addRule('subject', get_string('maximumchars', '', 255), 'maxlength', 255, 'client'); 
		
		$mform->addElement('htmleditor', 'message', 'Sua resposta', array('cols'=>50, 'rows'=>30));
        $mform->setType('message', PARAM_RAW);
        /*$mform->addRule('message', '', 'required', null, 'client');*/
		
		if ($forum->maxbytes != 1 && has_capability('mod/forum:createattachment', $modcontext))  {  //  1 = No attachments at all
            $mform->addElement('file', 'attachment', get_string('attachment', 'forum'));
            $mform->setHelpButton('attachment', array('attachment', get_string('attachment', 'forum'), 'myforum'));
        }
		
		/****************BOTOES E PARAMETROS************************/
		$mform->addElement('hidden', 'acc');
        $mform->setType('acc', PARAM_TEXT);
		
		$mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
		
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