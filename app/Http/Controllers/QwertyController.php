<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QwertyController extends Controller
{
    public $var = 'abc';

	public function xyz() {
		return view('page17');
	}

	public function abc(Request $request) {
		$name2 = $request->input('name2', 'Guest');
		
		return view('page18', ['name2' => $name2]);
	}

	public function abcd(Request $request) {
		echo $request->input('products.0.name');
		echo "\n";
		var_dump($request->input('products.*.price'));
		echo "\n";
		echo $request->input('user.name');
		echo "\n";
		echo $request->integer('user.name');
		echo "\n";
		var_dump($request->string('products.0.price'));
	}

	public function a20_get() {
		return view('page20');
	}

	public function a20_post(Request $request) {
		if($request->hasFile('file1')) {
			echo 'File1 uploaded: ' . $request->file('file1')->getClientOriginalName() . "<br>";
			echo 'File1 size: ' . $request->file('file1')->getSize() . "<br>";
			echo 'Max file size: ' . $request->file1->getMaxFilesize() . "<br>";
			echo 'File1 path: ' . $request->file1->path() . "<br>";
			echo 'File1 extension: ' . $request->file1->extension() . "<br>";
			echo 'File1 MIME Type: ' . $request->file1->getClientMimeType() . "<br>";
			$request->file1->move('./uploaded-file', 'file1.' . $request->file1->extension()) . "<br>";
		}

		//echo $request->file('file2')->store('folder1');
		//echo $request->file('file2')->store('folder1', 'private');
		//echo $request->file('file2')->store('folder1', 'public');
		//echo $request->file('file2')->storeAs('folder1', 'file2.jpg');
		echo $request->file('file2')->storeAs('folder1/sub-folder', 'file2.jpg', 'public');
		//return redirect()->route('page20-get')->withInput($request->except('dob'));
	}

	public function a21_get() {
		Storage::put('folder2/file1.txt', 'This is file1.txt in folder2.');
		//Storage::disk('public')->put('example.txt', 'This is content of example.txt file.');
		//echo Storage::disk('public')->get('example.txt');
		//echo "<img src='" . asset('storage/folder1/sub-folder/file2.jpg') . "'>";
		//echo "<img src='" . asset('uploaded-file/file1.png') . "'>";
		//echo "<img src='data:image/jpeg;base64," . base64_encode(Storage::disk('private')->get('folder1/file2.jpg')) . "'>";
		echo "<img src='" . route('get-photo', 2) . "'>";
	}

	public function getPhoto($userId) {
		return response()->file(storage_path("app/private/users-photos/{$userId}.jpg"));
	}
}
