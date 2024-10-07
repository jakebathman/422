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
    <script src="https://cdn.tailwindcss.com"></script>

    <title>422 Test</title>

</head>

<body>
    <div
        x-data="form"
        class="flex flex-col gap-5"
    >
        <div class="text-xl font-bold">
            422 Test
        </div>
        <div>Click submit with any content, and the server will respond with a 422.</div>
        <div>
            <form @submit.prevent="postForm">
                @csrf
                <input
                    class="border border-gray-300 p-2"
                    type="text"
                    name="email"
                    placeholder="Email"
                >
                <button
                    class="bg-blue-500 text-white p-2"
                    type="submit"
                >Submit</button>
            </form>
        </div>
        <div>
            <div><span class="font-bold">Status:</span> <span x-text="status"></span></div>
            <div><span class="font-bold">Response body:</span> <span x-text="response"></span></div>
            <div><span class="font-bold">Response headers:</span> <span x-text="headers"></span></div>
        </div>

        <hr />
        <div class="">
            <span class="text-lg font-bold">Request headers (for `welcome` request):</span>
            <pre>@json($headers, JSON_PRETTY_PRINT)</pre>
        </div>
    </div>
</body>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('form', () => ({
            headers: null,
            response: null,
            status: null,

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
                    .then(response => {
                        console.debug(response)
                        let headers = {}

                        response.headers.forEach((value, key) => {
                            headers[key] = value;
                        });

                        this.headers = JSON.stringify(headers)

                        this.status = response.status
                        return response.json()
                    })
                    .then(data => {
                        this.response = JSON.stringify(data)
                        console.log(data)
                    })
            }
        }))
    })
</script>

</html>
