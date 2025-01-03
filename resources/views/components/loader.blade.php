<div class="loader" >
        <div class="loading"></div>
</div>
<style>
.loader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 9999;

    .loading {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%); /* Bỏ rotate ở đây */
        display: flex;
        width: 3.5em;
        height: 3.5em;
        border: 3px solid transparent;
        border-top-color: #3cefff;
        border-bottom-color: #3cefff;
        border-radius: 50%;
        animation: spin 1.5s linear infinite;
    }

    .loading:before {
        content: "";
        display: block;
        margin: auto;
        width: 0.75em;
        height: 0.75em;
        border: 3px solid #3cefff;
        border-radius: 50%;
        animation: pulse 1s alternate ease-in-out infinite;
    }
}

@keyframes spin {
    from {
        transform: translate(-50%, -50%) rotate(0deg);
    }
    to {
        transform: translate(-50%, -50%) rotate(360deg);
    }
}

@keyframes pulse {
    from {
        transform: scale(0.5);
    }
    to {
        transform: scale(1);
    }
}
</style>