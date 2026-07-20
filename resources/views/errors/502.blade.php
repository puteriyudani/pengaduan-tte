@include('layouts.error', [
    'code' => '502',
    'title' => 'Bad Gateway',
    'message' => 'Server tidak dapat menerima respons yang valid dari layanan terkait.',
])
