<?php
	require_once($CFG->libdir.'/formslib.php');
class mod_myforum_concept_form extends moodleform {
	function definition() {
		global $CFG;
		
		$mform    =& $this->_form;
		$course        = $this->_customdata['course'];
        $cm            = $this->_customdata['cm'];
        $coursecontext = $this->_customdata['coursecontext'];
        $modcontext    = $this->_customdata['modcontext'];
        $forum         = $this->_customdata['forum'];
        $post          = $this->_customdata['post']; // hack alert
		
        
		
		//$mform->addElement('header', 'general', 'Bibliografia');//fill in the data depending on page params
				
		$mform->addElement('text', 'title', 'T&iacute;tulo', 'size="48"');
        $mform->setType('title', PARAM_TEXT);
        $mform->addRule('title', get_string('required'), 'required', null, 'client');
        $mform->addRule('title', get_string('maximumchars', '', 255), 'maxlength', 255, 'client'); 
		
		$mform->addElement('htmleditor', 'text', 'Texto', array('cols'=>50, 'rows'=>30));
        $mform->setType('text', PARAM_RAW);
        $mform->addRule('text', '', 'required', null, 'client');
		
		
		
		/****************BOTOES E PARAMETROS************************/
		$mform->addElement('hidden', 'acc');
        $mform->setType('acc', PARAM_TEXT);
		
		$mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
		
		$mform->addElement('hidden', 'idconcept');
        $mform->setType('idconcept', PARAM_INT);
		
		$mform->addElement('hidden', 'discussion');
        $mform->setType('discussion', PARAM_INT);
		
		$mform->addElement('hidden', 'userid');
        $mform->setType('userid', PARAM_INT);
		
		$mform->addElement('hidden', 'forum');
        $mform->setType('forum', PARAM_INT);
		
		$mform->addElement('hidden', 'course');
        $mform->setType('course', PARAM_INT);
		
        $this->add_action_buttons(false, "Enviar Conceito");
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