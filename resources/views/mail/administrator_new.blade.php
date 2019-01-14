<h2>Welcome New Administrator</h2>

<p>Your Password is : {{$data['password']}}</p>

<p><a href="{{ route('adm.auth.login.from', ['mail' => $data['email'] ]) }}">Go to login page</a></p>