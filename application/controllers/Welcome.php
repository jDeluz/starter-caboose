<?php

/**
 * Our homepage. Show the most recently added quote.
 * 
 * controllers/Welcome.php
 *
 * ------------------------------------------------------------------------
 */
class Welcome extends Application {

	function __construct()
	{
		parent::__construct();
	}

	//-------------------------------------------------------------
	//  The normal pages
	//-------------------------------------------------------------

	function index()
	{
		$this->data['pagebody'] = 'justone';	// this is the view we want shown
		$this->data = array_merge($this->data, (array) $this->quotes->last());
		$this->caboose->needed('jrating','hollywood');
		$this->data['average'] =
			($this->data['vote_count'] > 0) ?
				($this->data['vote_total'] / $this->data['vote_count']) : 0;
		$this->render();
	}

	// handle a rating
	function rate()
	{
		// detect non-AJAX entry
		if (!isset($_POST['action'])) redirect("/");
		// extract parameters
		$id = intval($_POST['idBox']);
		$rate = intval($_POST['rate']);
		// update the posting
		$record = $this->quotes->get($id);
		if ($record != null) {
			$record->vote_total += $rate;
			$record->vote_count++;
			$this->quotes->update($record);
		}
		$response = 'Thanks for voting!';
		echo json_encode($response);
	}

}

/* End of file Welcome.php */
/* Location: application/controllers/Welcome.php */