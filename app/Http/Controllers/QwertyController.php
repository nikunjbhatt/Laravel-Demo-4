<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cookie;

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
		//Storage::put('folder2/file1.txt', 'This is file1.txt in folder2.');
		//Storage::disk('public')->put('example.txt', 'This is content of example.txt file.');
		//echo Storage::disk('public')->get('example.txt');
		//echo "<img src='" . asset('storage/folder1/sub-folder/file2.jpg') . "'>";
		//echo "<img src='" . asset('uploaded-file/file1.png') . "'>";
		//echo "<img src='data:image/jpeg;base64," . base64_encode(Storage::disk('private')->get('folder1/file2.jpg')) . "'>";
		//echo "<img src='" . route('get-photo', 2) . "'>";

		/*$disk = Storage::build([
    		'driver' => 'local',
    		'root' => __DIR__ . '/../../../',
		]);

		if($disk->put('example2.txt', 'This is content of example2.txt file.'))
			echo 'file put at ' . __DIR__ . '/../../../';
		else
			echo 'unable to write file at ' . __DIR__ . '/../../../';*/
		
		$jsonArray = [
			[ 'name' => 'Laptop', 'price' => 55000 ],
			[ 'name' => 'Desktop', 'price' => 35000 ],
			[ 'name' => 'Mobile', 'price' => 25000 ],
		];

		//Storage::put('example.json', json_encode($jsonArray));
		//print_r(Storage::json('example.json'));

		/*if(Storage::exists('abc.txt'))
			echo 'abc.txt file exist in default disk<br>';
		else
			echo "abc.txt file doesn't exist in default disk<br>";
		
		if(Storage::missing('abc.txt'))
			echo 'abc.txt file is missing in default disk<br>';
		
		if(Storage::exists('example.txt'))
			echo 'example.txt file exist in default disk<br>';
		
		if(Storage::disk('public')->exists('example.txt'))
			echo 'example.txt file exist in public disk<br>';
		else
			echo "example.txt file doesn't exist in public disk<br>";*/

		//return Storage::download('example.txt', 'abc.txt');

		//echo Storage::url('example.json');
		echo 'size: ' . Storage::size('example.json') . '<br>';
		echo 'last modified at: ' . date('d-m-Y H:i:s', Storage::lastModified('example.json')) . '<br>';
		echo 'MIME type: ' . Storage::mimeType('example.json') . '<br>';
		echo 'path: ' . Storage::path('example.json') . '<br>';
		//Storage::prepend('example.txt', "Prepended Text using Storage::prepend() method.\n");
		//Storage::append('example.txt', "\nAppended Text using Storage::append() method.");
		//Storage::copy('example.txt', 'example 2.txt');
		//Storage::move('example 2.txt', 'folder1/example 2.txt');
		//Storage::move('folder1/example 2.txt', 'folder2/example 3.txt');
		Storage::delete('folder2/example 3.txt');
	}

	public function getPhoto($userId) {
		return response()->file(storage_path("app/private/users-photos/{$userId}.jpg"));
	}

	public function a22_get() {
		$files = Storage::files('folder1');

		foreach($files as $file) {
			echo $file . '<br>';
		}

		echo '<br>All files<br>';
		$files = Storage::allFiles('folder1');

		foreach($files as $file) {
			echo $file . '<br>';
		}

		echo '<br>Directories<br>';
		$dirs = Storage::directories('.');

		foreach($dirs as $dir) {
			echo $dir . '<br>';
		}

		echo '<br>Directories and Sub-directories<br>';
		$dirs = Storage::allDirectories('.');

		foreach($dirs as $dir) {
			echo $dir . '<br>';
		}

		//Storage::makeDirectory('folder2/sub-folder2.1/sub-folder2.1.1');
		Storage::deleteDirectory('folder2/sub-folder2.1/sub-folder2.1.1');

		//Storage::disk('local')->put('example.txt', 'this is file example.txt.');
		//echo Storage::temporaryUrl('example.json', now()->addSeconds(8));
	}

	public function a28_get() {
		Cookie::queue('c3', '33', 11);
		return response()->view('page27'); //->withoutCookie('c1');
	}

	public function a29_get() {
		return redirect()->route('page28');
		return redirect('/page28');
	}

	public function a31_post(Request $request) {
		if($request->name != 'nikunj')
			return back()->withInput();
		else
			return 'name is: ' . $request->name;
	}

	public function a32_get() {
		return redirect()->action([UserController::class, 'show'], ['id' => 5]);
	}

	public function a35_get() {
		//return [UserController::class => 'a35_get', 'id' => 5];
		return response()->json([UserController::class => 'a35_get', 'id' => 5])
			->withCallback('abcd');
	}

	public function a36_get() {
		return response()->download('example.txt', 'abc.txt');
	}

	public function a37_get() {
		return response()->file('uploaded-file/file1.png');
	}

	public function a38_get() {
		return view('page37', ['occupation' => 'Accountant'])
			->with('name', 'Vijay')
			->with('age', 44);
	}
}
