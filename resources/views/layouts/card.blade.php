<style>
    .image-container {
        position: relative;
        display: inline-block;
    }

    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .overlay-text {
        color: white;
        font-weight: bold;
        text-align: center;
        position: absolute;
        top: 50%;
        left: 50%;
        font-size: 12px;
        transform: translate(-50%, -50%);
    }

    .image-container:hover .overlay {
        opacity: 1;
    }
</style>

<div style="padding-left: 15px; padding-top: 15px; display: inline-block;">
    <div class="card" style=" width: 175px;">
        <a href="{{ route('document.details', ['id' => $document->id]) }}">

        </a>
        <div class="card-body">
            <h6 style="display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 1; overflow: hidden; text-overflow: ellipsis;">
                {{ $title }}</h6>

        </div>

    </div>
</div>
