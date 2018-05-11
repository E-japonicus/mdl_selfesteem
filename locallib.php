<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Internal library of functions for module infosysselfesteem
 *
 * All the infosysselfesteem specific functions, needed to implement the module
 * logic, should go here. Never include this file from your lib.php!
 *
 * @package    mod_infosysselfesteem
 * @copyright  2016 Your Name <your@email.address>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/*
 * Does something really useful with the passed things
 *
 * @param array $things
 * @return object
 *function infosysselfesteem_do_something_useful(array $things) {
 *    return new stdClass();
 *}
 */

 function infosysselfesteem_rubric_upsert($input) {
     global $DB, $composite_key;

     if ($record = $DB->get_record('infosysselfesteem_rubric', $composite_key)) {
         foreach ($input as $key => $value) {
             $record->key = $value;
         }
         $record->timemodified = time();

         return $DB->updata_record('infosysselfesteem_rubric', $record);

     } else {
         $record = $input;
         $record->timecreated = time();

         return $DB->insert_record('infosysselfesteem_rubric', $record);
     }
 }