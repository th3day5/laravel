@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <embed src="{{ asset('storage/' . $pdfPath) }}#toolbar=1&navpanes=0&scrollbar=0&pagemode=none"
                       width="100%" height="600"/>
            </div>
        </div>
    </div>

    <form id="signature" method="POST" action="{{ route('generate-pdf') }}">
        @csrf
        <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-4">
                <input type="hidden" name="token" value="{{ $token }}"/>
                <input type="hidden" name="signature_base64" id="signature_base64" value="">
                <canvas height="100" width="300" class="signature-pad" style="border: 1px solid #000000;"></canvas>
                <p><a href="#" class="clear-button">Clear</a></p>

                <button id="base64" type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>

    <script>
        const canvas = document.querySelector('canvas');
        const form = document.querySelector('.signature');
        const clearButton = document.querySelector('.clear-button');

        const ctx = canvas.getContext('2d');

        let writingMode = false;

        const handlePointerDown = (event) => {
            writingMode = true;
            ctx.beginPath();
            const [positionX, positionY] = getCursorPosition(event);
            ctx.moveTo(positionX, positionY);
        }

        const handlePointerUp = () => {
            writingMode = false;
        }

        const handlePointerMove = (event) => {
            if (!writingMode) return
            const [positionX, positionY] = getCursorPosition(event);
            ctx.lineTo(positionX, positionY);
            ctx.stroke();
        }

        const getCursorPosition = (event) => {
            positionX = event.clientX - event.target.getBoundingClientRect().x;
            positionY = event.clientY - event.target.getBoundingClientRect().y;
            return [positionX, positionY];
        }

        ctx.lineWidth = 3;
        ctx.lineJoin = ctx.lineCap = 'round';

        canvas.addEventListener('pointerdown', handlePointerDown, {passive: true});
        canvas.addEventListener('pointerup', handlePointerUp, {passive: true});
        canvas.addEventListener('pointermove', handlePointerMove, {passive: true});

        function convertCanvasToBase64(canvas) {
            let image = new Image();

            image.src = canvas.toDataURL("image/png");

            return image.src;
        }

        document.getElementById('base64').addEventListener('click', function () {
            document.getElementById('signature_base64').value = convertCanvasToBase64(canvas);
            console.log(document.getElementById('signature_base64').value);
        });


    </script>
@endsection