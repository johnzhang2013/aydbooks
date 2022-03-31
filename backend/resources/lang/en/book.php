<?php

return [
	'common' => [
		'brr_status_0' => 'Normal returned',
		'brr_status_1' => 'Overdued returned',
		'brr_status_2' => 'Normal borrowing',
		'brr_status_3' => 'Overdued borrowing'
	],

	'borrow_action' => [
		'not_logged' => 'You need to logged as a user to borrow it!',
		'no_leadable' => 'Your borrowable credit is insufficient.',
		'member_forbidden' => 'Unfortunately, you have been banned from borrowing any books!',
		'already_borrowing_normal' => 'You have a borrow record for this book and have not returned it.',
		'already_borrowing_overdued' => 'You have a borrow record for this book and it\'s overdued.',
		'book_not_found' => 'Sorry, we could not find this book in our database.',
		'book_no_stock' => 'Sorry, this book is out of stock.Please try it again after several days.',
		'borrow_failure' => 'Sorry, you failed to borrow it due to unknown issue.',
		'borrow_success' => 'Congrats! You borrowed it successfully, Please enjoy reading it!'
	],

	'return_action' => [

	],
];