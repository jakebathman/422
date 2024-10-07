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

<body class="p-6">
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
            <span class="text-lg font-bold">Request headers (to load this page):</span>
            <div>
                CloudFlare proxy?
                @if ($headers->has('cf-ray'))
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        aria-label="Cloudflare"
                        role="img"
                        viewBox="0 0 512 512"
                        class="w-10 h-10 inline-block"
                    >
                        <rect
                            rx="15%"
                            fill="#ffffff"
                        />
                        <path
                            fill="#f38020"
                            d="M331 326c11-26-4-38-19-38l-148-2c-4 0-4-6 1-7l150-2c17-1 37-15 43-33 0 0 10-21 9-24a97 97 0 0 0-187-11c-38-25-78 9-69 46-48 3-65 46-60 72 0 1 1 2 3 2h274c1 0 3-1 3-3z"
                        />
                        <path
                            fill="#faae40"
                            d="M381 224c-4 0-6-1-7 1l-5 21c-5 16 3 30 20 31l32 2c4 0 4 6-1 7l-33 1c-36 4-46 39-46 39 0 2 0 3 2 3h113l3-2a81 81 0 0 0-78-103"
                        />
                    </svg>
                    <span class="text-[#f38020] font-bold">Enabled</span>
                @else
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        aria-label="Cloudflare"
                        role="img"
                        viewBox="0 0 512 512"
                        class="w-10 h-10 inline-block"
                    >
                        <rect
                            rx="15%"
                            fill="#ffffff"
                        />
                        <path
                            fill="#545454"
                            d="M331 326c11-26-4-38-19-38l-148-2c-4 0-4-6 1-7l150-2c17-1 37-15 43-33 0 0 10-21 9-24a97 97 0 0 0-187-11c-38-25-78 9-69 46-48 3-65 46-60 72 0 1 1 2 3 2h274c1 0 3-1 3-3z"
                        />
                        <path
                            fill="#999999"
                            d="M381 224c-4 0-6-1-7 1l-5 21c-5 16 3 30 20 31l32 2c4 0 4 6-1 7l-33 1c-36 4-46 39-46 39 0 2 0 3 2 3h113l3-2a81 81 0 0 0-78-103"
                        />
                    </svg>
                    <span class="text-[#444444] font-bold">Not Enabled</span>
                @endif
            </div>
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
