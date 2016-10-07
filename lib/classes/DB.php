<?php
// 데이터베이스 연결 클래스
class DB{
	var $Database = "DB 이름";
	var $Host = "DB 호스트";
	var $User = "DB 아이디";
	var $Password = "DB 비밀번호";

	var $Link_ID = 0;
	var $Query_ID = 0;
	var $Record = array();
	var $Row;

	var $Errno = 0;
	var $Error = "";

	var $debug_addr = "";

	// 생성자
	function __construct( $debug_addr = '' ){
		$this->debug_addr = $debug_addr;
	}

	// 연결 메소드
	private function connect() {
		if ( !$this->Link_ID ) {
			$this->Link_ID = mysqli_connect( $this->Host, $this->User, $this->Password, $this->Database );
			if ( !$this->Link_ID ) {
				$this->halt("Link-ID == false, pconnect failed");
			}
			if ( !mysqli_query( $this->Link_ID, sprintf("use %s",$this->Database) ) ) {
				$this->halt("cannot use database ".$this->Database);
			}
			mysqli_query( $this->Link_ID, "SET NAMES 'utf8'" );
		}
	}

	// 쿼리 메소드
	public function query( $query_str ) {
		$this->connect();
		$this->Query_ID = mysqli_query( $this->Link_ID, $query_str );
		$this->Row = 0;
		$this->Errno = mysqli_errno( $this->Link_ID );
		$this->Error = mysqli_error( $this->Link_ID );
		if( !$this->Query_ID ) {
			$this->halt("SQL Syntax error. (".$query_str.")");
		}
		return $this;
	}

	// 배열 형태로 1행을 가져오는 메소드 
	public function nfa(){
		return $this->next_fetch_array();
	}

	// 열 형태로 1행을 가져오는 메소드
	public function nfr(){
		return $this->next_fetch_row();
	}

	// 객체 형태로 1행을 가져오는 메소드
	public function nfo(){
		return $this->next_fetch_object();
	}

	// 모든 열을 배열로 가져오는 메소드
	public function fetch_all_rows(){
		while($tmp=$this->nfr()){
			$tmp2[]=$tmp;
		}
		return $tmp2;
	}

	// 모든 배열을 배열로 가져오는 메소드
	public function fetch_all_arrays(){
		while($tmp=$this->nfa()){
			$tmp2[]=$tmp;
		}
		return $tmp2;
	}

	// 모든 객체를 배열로 가져오는 메소드
	public function fetch_all_objects(){
		while($tmp=$this->nfo()){
			$tmp2[]=$tmp;
		}
		return $tmp2;
	}

	public function result_array_all(){
		$tmp = Array();
		$i=0;
		while( $data = $this->next_fetch_array() ){
			$tmp[$i++]=$data;
		}
		return $tmp;
	}

	public function next_fetch_array(){
		if(!$this->Link_ID) return false;
		$this->Record = mysqli_fetch_array($this->Query_ID);
		$this->Errno = mysqli_errno( $this->Link_ID );
		$this->Error = mysqli_error( $this->Link_ID );

		$stat = is_array( $this->Record );
		if (!$stat) {
			mysqli_free_result( $this->Query_ID );
			$this->Query_ID = 0;
		}
		return $this->Record;
	}

	public function next_fetch_row(){
		if(!$this->Link_ID) return false;

		$this->Record = @mysqli_fetch_row($this->Query_ID, $this->Row++);
		$this->Errno = mysqli_errno( $this->Link_ID );
		$this->Error = mysqli_error( $this->Link_ID );
		$stat = is_array($this->Record);
		if (!$stat) {
			mysqli_free_result($this->Query_ID);
			$this->Query_ID = 0;
		}
		return $this->Record;
	}

	public function next_fetch_object(){
		if(!$this->Link_ID) return false;

		$this->Record = @mysqli_fetch_object($this->Query_ID);
		$this->Errno = mysqli_errno( $this->Link_ID );
		$this->Error = mysqli_error( $this->Link_ID );
		$stat = is_object($this->Record);
		if (!$stat) {
			mysqli_free_result($this->Query_ID);
			$this->Query_ID = 0;
		}
		return $this->Record;
	}

	public function get_var( $query_str ){
		$this->connect();
		$this->Query_ID = mysqli_query( $this->Link_ID, $query_str );
		$this->Record = mysqli_fetch_array($this->Query_ID);
		$this->Row = 0;
		$this->Errno = mysqli_errno( $this->Link_ID );
		$this->Error = mysqli_error( $this->Link_ID );
		if( !$this->Query_ID ) {
			$this->halt("SQL Syntax error. (".$query_str.")");
		}
		$stat = is_array( $this->Record );
		if (!$stat) {
			mysqli_free_result( $this->Query_ID );
			$this->Query_ID = 0;
		}
		return $this->Record[0];
	}

	public function get_vars( $query_str ){
		$this->connect();
		$this->Query_ID = mysqli_query( $this->Link_ID, $query_str );
		$this->Record = mysqli_fetch_array($this->Query_ID);
		$this->Row = 0;
		$this->Errno = mysqli_errno( $this->Link_ID );
		$this->Error = mysqli_error( $this->Link_ID );
		if( !$this->Query_ID ) {
			$this->halt("SQL Syntax error. (".$query_str.")");
		}
		$stat = is_array( $this->Record );
		if (!$stat) {
			mysqli_free_result( $this->Query_ID );
			$this->Query_ID = 0;
		}
		return $this->Record;
	}

	public function affected_rows() {
		return mysqli_affected_rows($this->Link_ID);
	}

	public function num_rows() {
		return @mysqli_num_rows($this->Query_ID);
	}

	public function num_fields() {
		return mysqli_num_fields($this->Query_ID);
	}

	public function escape_string( $query ) {
		$this->connect();
		return mysqli_escape_string($this->Link_ID, $query);
	}

	public function insert_id() {
		return mysqli_insert_id( $this->Link_ID );
	}

	public function autocommit(){
		$this->connect();
		return mysqli_autocommit( $this->Link_ID, FALSE );
	}

	public function commit(){
		return mysqli_commit( $this->Link_ID );
	}


	public function rollback(){
		return mysqli_rollback( $this->Link_ID );
	}

	private function halt($msg) {
		if( $_SERVER['REMOTE_ADDR'] == $this->debug_addr ){
			$call = $_SERVER['PHP_SELF'];
			echo "<pre>";
			echo "<b>DB Error occurred.</b>\n";
			echo "<b>- msg : </b>".$msg."\n";
			echo "<b>- code : </b>".$this->Errno." (".$this->Error.")\n";
			echo "<b>- call : </b>".$call."\n";
			echo "</pre>";
			die("<pre>DB Close.</pre>");
		}
	}
}
?>
