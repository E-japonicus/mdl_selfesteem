<?php
require_once("{$CFG->libdir}/formslib.php");
// require_once("./style.css");

class infosysselfesteem_form extends moodleform {
  public function definition() {
    global $USER, $infosysselfesteem;

    $mform = $this->_form;

    $this->rubric_1_form();

    $this->rubric_2_form();

    $this->rubric_3_form();

    $this->rubric_4_form();

    $this->rubric_5_form();

    $this->rubric_6_form();

    $this->rubric_7_form();

    $this->rubric_8_form();

    $this->rubric_9_form();

    $this->rubric_10_form();

    $this->rubric_11_form();

    $mform->addElement('hidden', 'user_id', $USER->id);
    $mform->setType('user_id', PARAM_INT);

    $mform->addElement('hidden', 'infosysselfesteem_id', $infosysselfesteem->id);
    $mform->setType('infosysselfesteem_id', PARAM_INT);

    $this->add_action_buttons(false);
  }

  private function rubric_1_form(){
    $mform = $this->_form;

    $mform->addElement('header', 'rubric_1_title', get_string('rubric[1]', 'infosysselfesteem'));
    $mform->setExpanded('rubric_1_title');
    // $mform->addHelpButton('rubric_1_title', 'rubric[1]', 'infosysselfesteem');

    $radioarray=array();
    $radioarray[] = $mform->createElement('radio',  'rubric_1', '', get_string('rubric[1]_score0', 'infosysselfesteem'), 0,  $attributes);
    $radioarray[] = $mform->createElement('radio',  'rubric_1', '', get_string('rubric[1]_score1', 'infosysselfesteem'), 1,  $attributes);
    $radioarray[] = $mform->createElement('radio',  'rubric_1', '', get_string('rubric[1]_score2', 'infosysselfesteem'), 2,  $attributes);
    $radioarray[] = $mform->createElement('radio',  'rubric_1', '', get_string('rubric[1]_score3', 'infosysselfesteem'), 3,  $attributes);
    $mform->addGroup($radioarray, 'radioar', get_string('rubric[1]_suffix', 'infosysselfesteem'), array('<br />'), false);
    $mform->setType('rubric_1', PARAM_INT);
    
    
  }

  private function rubric_2_form(){
    $mform = $this->_form;

    $mform->addElement('header', 'rubric_2_title', get_string('rubric[2]', 'infosysselfesteem'));
    $mform->setExpanded('rubric_2_title');
    // $mform->addHelpButton('rubric_2_title', 'rubric[2]', 'infosysselfesteem');

    $radioarray=array();
    $radioarray[] = $mform->createElement('radio',  'rubric_2', '', get_string('rubric[2]_score0', 'infosysselfesteem'), 0,  $attributes);
    $radioarray[] = $mform->createElement('radio',  'rubric_2', '', get_string('rubric[2]_score1', 'infosysselfesteem'), 1,  $attributes);
    $radioarray[] = $mform->createElement('radio',  'rubric_2', '', get_string('rubric[2]_score2', 'infosysselfesteem'), 2,  $attributes);
    $mform->addGroup($radioarray, 'radioar', get_string('rubric[2]_suffix', 'infosysselfesteem'), array('<br />'), false);
    $mform->setType('rubric_2', PARAM_INT);
  }

  private function rubric_3_form(){
    $mform = $this->_form;

    $mform->addElement('header', 'rubric_3_title', get_string('rubric[3]', 'infosysselfesteem'));
    $mform->setExpanded('rubric_3_title');
    // $mform->addHelpButton('rubric_3_title', 'rubric[3]', 'infosysselfesteem');

    $radioarray=array();
    $radioarray[] = $mform->createElement('radio',  'rubric_3', '', get_string('rubric[3]_score0', 'infosysselfesteem'), 0,  $attributes);
    $radioarray[] = $mform->createElement('radio',  'rubric_3', '', get_string('rubric[3]_score1', 'infosysselfesteem'), 1,  $attributes);
    $radioarray[] = $mform->createElement('radio',  'rubric_3', '', get_string('rubric[3]_score2', 'infosysselfesteem'), 2,  $attributes);
    $mform->addGroup($radioarray, 'radioar', get_string('rubric[3]_suffix', 'infosysselfesteem'), array('<br />'), false);
    $mform->setType('rubric_3', PARAM_INT);
  }

  private function rubric_4_form(){
    $mform = $this->_form;

    $mform->addElement('header', 'rubric_4_title', get_string('rubric[4]', 'infosysselfesteem'));
    $mform->setExpanded('rubric_4_title');
    $mform->addHelpButton('rubric_4_title', 'good_quiz', 'infosysselfesteem');

    $radioarray=array();
    $radioarray[] = $mform->createElement('radio',  'rubric_4', '', get_string('rubric[4]_score1', 'infosysselfesteem'), 1,  $attributes);
    $radioarray[] = $mform->createElement('radio',  'rubric_4', '', get_string('rubric[4]_score2', 'infosysselfesteem'), 2,  $attributes);
    $radioarray[] = $mform->createElement('radio',  'rubric_4', '', get_string('rubric[4]_score3', 'infosysselfesteem'), 3,  $attributes);
    $mform->addGroup($radioarray, 'radioar', get_string('rubric[4]_suffix', 'infosysselfesteem'), array('<br />'), false);
    $mform->setType('rubric_4', PARAM_INT);
  }

  private function rubric_5_form(){
    $mform = $this->_form;

    $mform->addElement('header', 'rubric_5_title', get_string('rubric[5]', 'infosysselfesteem'));
    $mform->setExpanded('rubric_5_title');
    // $mform->addHelpButton('rubric_5_title', 'rubric[5]', 'infosysselfesteem');

    $radioarray=array();
    $radioarray[] = $mform->createElement('radio',  'rubric_5', '', get_string('rubric[5]_score0', 'infosysselfesteem'), 0,  $attributes);
    $radioarray[] = $mform->createElement('radio',  'rubric_5', '', get_string('rubric[5]_score1', 'infosysselfesteem'), 1,  $attributes);
    $radioarray[] = $mform->createElement('radio',  'rubric_5', '', get_string('rubric[5]_score2', 'infosysselfesteem'), 2,  $attributes);
    $mform->addGroup($radioarray, 'radioar', get_string('rubric[5]_suffix', 'infosysselfesteem'), array('<br />'), false);
    $mform->setType('rubric_5', PARAM_INT);
  }

  private function rubric_6_form(){
    $mform = $this->_form;

    $mform->addElement('header', 'rubric_6_title', get_string('rubric[6]', 'infosysselfesteem'));
    $mform->setExpanded('rubric_6_title');
    $mform->addHelpButton('rubric_6_title', 'good_quiz', 'infosysselfesteem');

    $radioarray=array();
    $radioarray[] = $mform->createElement('radio',  'rubric_6', '', get_string('rubric[6]_score1', 'infosysselfesteem'), 1,  $attributes);
    $radioarray[] = $mform->createElement('radio',  'rubric_6', '', get_string('rubric[6]_score2', 'infosysselfesteem'), 2,  $attributes);
    $radioarray[] = $mform->createElement('radio',  'rubric_6', '', get_string('rubric[6]_score3', 'infosysselfesteem'), 3,  $attributes);
    $mform->addGroup($radioarray, 'radioar', get_string('rubric[6]_suffix', 'infosysselfesteem'), array('<br />'), false);
    $mform->setDefault('rubric_6',1);
    $mform->setType('rubric_6', PARAM_INT);
  }

  private function rubric_7_form(){
    $mform = $this->_form;

    $mform->addElement('header', 'rubric_7_title', get_string('rubric[7]', 'infosysselfesteem'));
    $mform->setExpanded('rubric_7_title');
    // $mform->addHelpButton('rubric_7_title', 'rubric[7]', 'infosysselfesteem');

    $radioarray=array();
    $radioarray[] = $mform->createElement('radio',  'rubric_7', '', get_string('rubric[7]_score0', 'infosysselfesteem'), 0,  $attributes);
    $radioarray[] = $mform->createElement('radio',  'rubric_7', '', get_string('rubric[7]_score1', 'infosysselfesteem'), 1,  $attributes);
    $radioarray[] = $mform->createElement('radio',  'rubric_7', '', get_string('rubric[7]_score2', 'infosysselfesteem'), 2,  $attributes);
    $mform->addGroup($radioarray, 'radioar', get_string('rubric[7]_suffix', 'infosysselfesteem'), array('<br />'), false);
    $mform->setType('rubric_7', PARAM_INT);
  }

  private function rubric_8_form(){
    $mform = $this->_form;

    $mform->addElement('header', 'rubric_8_title', get_string('rubric[8]', 'infosysselfesteem'));
    $mform->setExpanded('rubric_8_title');
    // $mform->addHelpButton('rubric_8_title', 'rubric[8]', 'infosysselfesteem');

    $radioarray=array();
    $radioarray[] = $mform->createElement('radio',  'rubric_8', '', get_string('rubric[8]_score0', 'infosysselfesteem'), 0,  $attributes);
    $radioarray[] = $mform->createElement('radio',  'rubric_8', '', get_string('rubric[8]_score1', 'infosysselfesteem'), 1,  $attributes);
    $radioarray[] = $mform->createElement('radio',  'rubric_8', '', get_string('rubric[8]_score2', 'infosysselfesteem'), 2,  $attributes);
    $mform->addGroup($radioarray, 'radioar', get_string('rubric[8]_suffix', 'infosysselfesteem'), array('<br />'), false);
    $mform->setType('rubric_8', PARAM_INT);
  }

  private function rubric_9_form(){
    $mform = $this->_form;

    $mform->addElement('header', 'rubric_9_title', get_string('rubric[9]', 'infosysselfesteem'));
    $mform->setExpanded('rubric_9_title');
    // $mform->addHelpButton('rubric_9_title', 'rubric[9]', 'infosysselfesteem');

    $radioarray=array();
    $radioarray[] = $mform->createElement('radio',  'rubric_9', '', get_string('rubric[9]_score0', 'infosysselfesteem'), 0,  $attributes);
    $radioarray[] = $mform->createElement('radio',  'rubric_9', '', get_string('rubric[9]_score1', 'infosysselfesteem'), 1,  $attributes);
    $radioarray[] = $mform->createElement('radio',  'rubric_9', '', get_string('rubric[9]_score2', 'infosysselfesteem'), 2,  $attributes);
    $mform->addGroup($radioarray, 'radioar', get_string('rubric[9]_suffix', 'infosysselfesteem'), array('<br />'), false);
    $mform->setType('rubric_9', PARAM_INT);
  }

  private function rubric_10_form(){
    $mform = $this->_form;

    $mform->addElement('header', 'rubric_10_title', get_string('rubric[10]', 'infosysselfesteem'));
    $mform->setExpanded('rubric_10_title');
    // $mform->addHelpButton('rubric_10_title', 'rubric[10]', 'infosysselfesteem');

    $radioarray=array();
    $radioarray[] = $mform->createElement('radio',  'rubric_10', '', get_string('rubric[10]_score0', 'infosysselfesteem'), 0,  $attributes);
    $radioarray[] = $mform->createElement('radio',  'rubric_10', '', get_string('rubric[10]_score1', 'infosysselfesteem'), 1,  $attributes);
    $radioarray[] = $mform->createElement('radio',  'rubric_10', '', get_string('rubric[10]_score2', 'infosysselfesteem'), 2,  $attributes);
    $mform->addGroup($radioarray, 'radioar', get_string('rubric[10]_suffix', 'infosysselfesteem'), array('<br />'), false);
    $mform->setType('rubric_10', PARAM_INT);
  }

  private function rubric_11_form(){
    $mform = $this->_form;

    $mform->addElement('header', 'rubric_11_title', get_string('rubric[11]', 'infosysselfesteem'));
    $mform->setExpanded('rubric_11_title');
    $mform->addHelpButton('rubric_11_title', 'exercise_goal', 'infosysselfesteem');

    $radioarray=array();
    $radioarray[] = $mform->createElement('radio',  'rubric_11', '', get_string('rubric[11]_score0', 'infosysselfesteem'), 0,  $attributes);
    $radioarray[] = $mform->createElement('radio',  'rubric_11', '', get_string('rubric[11]_score1', 'infosysselfesteem'), 1,  $attributes);
    $radioarray[] = $mform->createElement('radio',  'rubric_11', '', get_string('rubric[11]_score2', 'infosysselfesteem'), 2,  $attributes);
    $mform->addGroup($radioarray, 'radioar', get_string('rubric[11]_suffix', 'infosysselfesteem'), array('<br />'), false);
    $mform->setType('rubric_11', PARAM_INT);
  }
 
}

?>
