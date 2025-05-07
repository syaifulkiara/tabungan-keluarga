<?php 

function check_already_login(){
	$CI =& get_instance();
	$user_session = $CI->session->userdata('fid');
	if($user_session){
		redirect('dashboard');
	}
}

function check_not_login(){
	$CI =& get_instance();
	$user_session = $CI->session->userdata('fid');
	if(!$user_session){
		redirect('login');
	}
}

function check_admin(){
	$CI =& get_instance();
	$CI->load->library('fungsi');
	if($CI->fungsi->user_login()->fisadmin != 1 ){
		redirect('dashboard');
	}

}

function format_tanggal_indonesia($datetime)
{
    // Pastikan ekstensi intl aktif
    $date = new DateTime($datetime);

    // Format lokal Indonesia
    $formatter = new IntlDateFormatter(
        'id_ID', // locale Indonesia
        IntlDateFormatter::FULL, // date format (FULL = Hari, DD MM YYYY)
        IntlDateFormatter::SHORT, // time format (HH:MM)
        'Asia/Jakarta', // time zone
        IntlDateFormatter::GREGORIAN,
        "EEEE, dd-MM-yyyy HH:mm" // custom pattern
    );

    return $formatter->format($date);
}
