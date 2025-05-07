<?php 

	Class Fungsi {
		protected $CI;
		public function __construct(){
		$this->CI =& get_instance();
	}

	function user_login(){
		$this->CI->load->model('User_m');
		$fid 	= $this->CI->session->userdata('fid');
		$user_data 	= $this->CI->User_m->get($fid)->row();
		return $user_data;
	}

	function PdfGenerator($html, $filename, $paper, $orientation){
		$dompdf = new Dompdf\Dompdf();
		$dompdf->loadHtml($html);
		// (Optional) Setup the paper size and orientation
		$dompdf->setPaper($paper, $orientation);
		// Render the HTML as PDF
		$dompdf->render();
		// Output the generated PDF to Browser
		$dompdf->stream($filename, array('Attachment' => 0));
	}
}