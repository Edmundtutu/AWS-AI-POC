Dropzone.options.myDropzone = {
    paramName: "file",
    maxFilesize: 10, // MB
    acceptedFiles: ".jpeg,.jpg,.png,.gif,.doc,.docx,.pdf,.zip,.mp3",
    dictDefaultMessage: `<i class="fas fa-cloud-upload-alt fa-3x text-info mb-3"></i>
                        <h5>Drag and drop files here</h5>
                        <p class="text-muted">or click to browse</p>`,
    autoProcessQueue: false,
    addRemoveLinks: true,
    dictRemoveFile: "Remove",
    init: function() {
        var myDropzone = this;
        var submitButton = document.querySelector("#submit-dropzone");

        // Handle the submit button click
        submitButton.addEventListener("click", function(e) {
            e.preventDefault();
            if (myDropzone.getQueuedFiles().length === 0) {
                alert("Please add files to upload.");
                return;
            }
            myDropzone.processQueue();
        });

        // File upload success
        this.on("success", function(file, response) {
            if (this.getQueuedFiles().length === 0 && this.getUploadingFiles().length === 0) {
                // Redirect to files list after all uploads complete
                window.location.href = '/files';
            }
        });

        // File upload error
        this.on("error", function(file, errorMessage) {
            alert("Error uploading file: " + errorMessage);
        });

        // Update submit button state when files are added
        this.on("addedfile", function(file) {
            submitButton.classList.remove("btn-secondary");
            submitButton.classList.add("btn-info");
        });

        // Update submit button state when files are removed
        this.on("removedfile", function(file) {
            if (this.files.length === 0) {
                submitButton.classList.remove("btn-info");
                submitButton.classList.add("btn-secondary");
            }
        });
    }
}; 