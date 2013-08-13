<?php
class Controller_Test extends Controller_Template
{
	public function action_api()
	{
		// For API Calls Set the orgin here
		
		// TODO - Put their website url where * is to make it more secure 
		header('Access-Control-Allow-Origin: *');
		
		// Decodes the JSON into an PHP Object
		$data_object = json_decode($_POST['data']);
		
		// Loop through the object and store information
		foreach($data_object as $key => $data)
		{
			echo ucwords(preg_replace('/_/',' ',$key)).' : '.$data."<br>";
		}
		
		// Since no response needed we can just kill it here
		die;
	}
        
        public function action_autoupdate()
        {
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: GET');
            echo json_encode('[
                             {"question_post_time":1373739501,"question_vote_count":102,"question_auser_id":null,"question_question":"How does the style differ from the Uk from the USA?","question_id":5},
                             {"question_post_time":1373909272,"question_vote_count":146,"question_auser_id":null,"question_question":"What was the best decade for style and fashion? 60s, 70s, 80s, 90s, now?","question_id":10},
			     {"question_post_time":1373739501,"question_vote_count":105,"question_auser_id":null,"question_question":"How old were you when you decided to become astylist?","question_id":4},
                             {"question_post_time":1373909272,"question_vote_count":100,"question_auser_id":null,"question_question":"Do you do any modelling/ have done?","question_id":9},
                             {"question_post_time":1373739501,"question_vote_count":14,"question_auser_id":null,"question_question":"Which country do you think has the best style?","question_id":6},
                             {"question_post_time":1373909272,"question_vote_count":13,"question_auser_id":null,"question_question":"Do you know of any good belt companies?","question_id":14},
                             {"question_post_time":1373909272,"question_vote_count":8,"question_auser_id":null,"question_question":"Do you work out much?","question_id":11},
                             {"question_post_time":1373729287,"question_vote_count":7,"question_auser_id":null,"question_question":" How did you get into the fashion industry?","question_id":7},
                             {"question_post_time":1373909272,"question_vote_count":1,"question_auser_id":null,"question_question":"What are your favourite watch brands?","question_id":12},
			     {"question_post_time":1373909272,"question_vote_count":0,"question_auser_id":null,"question_question":"What are your favourite watch brands?","question_id":13}]');
            die;
        }
}
