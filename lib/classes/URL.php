<?php
// URL 처리 클래스
class URL {
	var $db;

	// 생성자
	public function __construct() {
		$this->db = new DB();
	}

	// 결과를 DB에 저장하는 메소드
	public function insert_url_info($url) {
		$sql = "select * from url where original_url = '$url';";
		$result = $this->db->query($sql)->next_fetch_object();

		if($result != null) {
			return array(
				"shorten_url"=>$result->shorten_url
			);
		}

		$shorten_url = $this->create_shorten_url();

		$sql = "insert into url values(NULL, '$url', '$shorten_url', 0, now());";
		$result = $this->db->query($sql)->affected_rows();

		if($result) {
			return array(
				"shorten_url"=>$shorten_url
			);
		}

		return -1;
	}

	// 짧은 URL 생성 메소드
	public function create_shorten_url() {
		$sql = "select count(*) as cnt from url;";
		$result = $this->db->query($sql)->next_fetch_object();

		return base_convert($result->cnt + 1, 10, 36);
	}

	// 원본 URL을 가져오는 메소드
	public function get_original_url($shorten_url) {
		$sql = "select * from url where shorten_url = '$shorten_url' limit 1;";
		$result = $this->db->query($sql)->next_fetch_object();

		return $result;
	}

	// 접속 횟수를 집계하는 메소드
	public function add_url_hits($shorten_url) {
		$shorten_url = str_replace("http://".$_SERVER['SERVER_NAME']."/", "", $shorten_url);

		$sql = "update url set hits = hits + 1 where shorten_url = '$shorten_url';";
		$this->db->query($sql);
	}
}
?>
