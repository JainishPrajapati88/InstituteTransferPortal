$(document).ready(function () {
    const dropArea = $('#nocLable');
    const inputFile = $('#nocLetter');
    const fileNameDisplay = $('#file-name'); 
    dropArea.on('dragover', function (e) {
        e.preventDefault();
    });
    dropArea.on('drop', function (e) {
        e.preventDefault();
        inputFile.prop('files', e.originalEvent.dataTransfer.files);
        var nocLetter = $('#nocLetter')[0].files[0]; 
        if (nocLetter) {
            if (nocLetter.type === 'application/pdf') {
                $('#alert').addClass('hidden'); 
                $('#submit').removeAttr('disabled');
                $('#submit').removeClass('cursor-not-allowed');
                $('#hight').addClass('h-140');
                $('#hight').removeClass('h-160');
            } else {
                $('#alert').removeClass('hidden'); 
                $('#submit').addClass('cursor-not-allowed');
                $('#submit').attr('disabled', 'disabled');
                $('#hight').removeClass('h-140');
                $('#hight').addClass('h-160');
                e.preventDefault(); 
            }
            fileNameDisplay.text(nocLetter.name);
        }
    });
});
$("#nocLetter").change(function () {
    $("#file-name").text(this.files[0].name);
});
$("#nocLetter").change(function (e) {
    var nocLetter = $('#nocLetter')[0].files[0]; 
    if (nocLetter) {
        if (nocLetter.type === 'application/pdf') {
            $('#alert').addClass('hidden'); 
            $('#submit').removeAttr('disabled');
            $('#submit').removeClass('cursor-not-allowed');
            $('#hight').removeClass('cursor-not-allowed');
            $('#hight').addClass('h-140');
            $('#hight').removeClass('h-160');
        } else {
            $('#alert').removeClass('hidden'); 
            $('#submit').addClass('cursor-not-allowed');
            $('#submit').attr('disabled', 'disabled');
            $('#hight').removeClass('h-140');
            $('#hight').addClass('h-160');
            e.preventDefault(); 
        }
    }
});