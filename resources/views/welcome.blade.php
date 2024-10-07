<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >
    <script
        defer
        src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"
    ></script>

    <title>422 Test</title>

</head>

<body>
    <div
        class="content"
        x-data="form"
    >
        <div class="title m-b-md">
            422 Test
        </div>
        <div class="links">
            <form @submit.prevent="postForm">
                @csrf
                <input
                    type="text"
                    name="email"
                    placeholder="Email"
                >
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
</body>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('form', () => ({
            postForm() {
                fetch('/test', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: JSON.stringify({
                        email: document.querySelector('input[name="email"]').value
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data)
                })
            }
        }))
    })
</script>

</html>
