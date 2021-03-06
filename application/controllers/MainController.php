<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class MainController extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('Fbuser_model');
		$this->load->model('Ranking_model');
		$this->load->library('facebook');
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('update_rank_helper');
		update_user_rank_session();
	}

	public function index(){
		$this->load->view('home');
	}

	public function facebook_login(){
		$facebook_player = $this->Fbuser_model;
		if ($this->facebook->logged_in()){
			$user = $this->facebook->user();
			if ($user['code'] === 200){
				unset($user['data']['permissions']);
				$facebook_player->set_facebook_id($user['data']['id']);
				$facebook_player->set_facebook_name($user['data']['name']);
				if (!$facebook_player->is_exist($user['data']['id'])){
					if(!$facebook_player->save()){
						echo "Unable to save your facebook data to our database";
					}
				}
				$this->session->set_userdata('user_id', $user['data']['id']);
				$this->session->set_userdata('user_name', $user['data']['name']);
			}else{
				echo "Facebook Login Failed!";
			}
			// $friend_array is a set of friends to be saved at facebook_friend table
			$friend_array = $facebook_player->get_friends($user['data']['id']);
			if(isset($friend_array)){
				$facebook_player->save_friend($user['data']['id'], $friend_array);
			}
		}
	}

	public function main(){
		if(!$this->session->userdata('user_id')){
			$this->facebook_login();
		}

		$ranking = $this->Ranking_model;
		$total_number_of_page = $ranking->get_total_number_of_page();
		$this->load->view('main', array(
										'total_number_of_page' => $total_number_of_page 
									)
						 );
	}

	public function facebook_logout(){
		$this->facebook->destroy_session();
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('user_name');
		$this->session->unset_userdata('question_group');
		redirect('home', redirect);
	}

	public function change_ranking_page($page){
		$ranking = $this->Ranking_model;
		$total_number_of_page = $ranking->get_total_number_of_page();
		$ranking_for_page = $ranking->get_ranking_by_page($page);
		$this->load->view('ranking_data', array(
										'ranking_for_page' => $ranking_for_page,
										'total_number_of_page' => $total_number_of_page 
									)
						 );
	}

	public function set_friend_only_session(){
		$checked = $this->input->post('checked');
		$this->session->set_userdata('show_friend_only', $checked);
	}

	public function begin_again(){
		$user_id = $this->session->userdata('user_id');
		$ranking = $this->Ranking_model;
		if($ranking->reset_ranking($user_id)){
			echo "success";
		}else{
			echo "unsuccess";
		}
	}
}