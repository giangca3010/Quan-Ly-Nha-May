@extends("app")
@section("css")
<script src="{{asset('js/underscore-min.js')}}"></script>
<script src="{{asset('js/jquery-textntags.js')}}"></script>
<style type="text/css">
.textarea-container {
    position: relative;
    width: 100%;
}

textarea, .textarea-size {
    min-height: 100px;
    font-family: sans-serif;
    font-size: 14px;
    box-sizing: border-box;
    padding: 4px;
    border: 1px solid;
    overflow: hidden;
    width: 100%;
}

textarea {
    height: 100%;
    position: absolute;
    resize: none;
    white-space: normal;
    border: 2px solid #ccc;
    border-radius: 4px;
}

.textarea-size {
    visibility: hidden;
    white-space: pre-wrap;
    word-wrap: break-word;
    overflow-wrap: break-word;
    display: none;
}

.header-input button{
	width: 100%;
	border-radius: 4px;
	margin-top: 10px;
}

.textntags-wrapper {
    position: relative;
	min-height: 100px;
}

.textntags-wrapper textarea {
    position: absolute;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    width: 100%;
    display: block;
    padding: 9px;
    margin: 0;
    border: 1px solid #dcdcdc;
    border-radius: 3px;
    overflow: hidden;
    background: transparent;
    outline: 0;
    resize: none;
    font-family: Arial;
    font-size: 13px;
    line-height: 17px;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
	background-color: rgba(215, 247, 178, 0.3);
}

@-moz-document url-prefix() {
    .textntags-wrapper textarea {
        padding: 9px 8px;
    }
}

.textntags-wrapper .textntags-tag-list {
    display: none;
    background: #fff;
    border: 1px solid #b2b2b2;
    position: absolute;
    left: 0;
    right: 0;
    z-index: 10000;
    margin-top: -2px;
    border-radius: 5px;
    border-top-right-radius: 0;
    border-top-left-radius: 0;
    -webkit-box-shadow: 0 2px 5px rgba(0, 0, 0, 0.148438);
    -moz-box-shadow: 0 2px 5px rgba(0, 0, 0, 0.148438);
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.148438);
}

.textntags-wrapper .textntags-tag-list ul {
    margin: 0;
    padding: 0;
}

.textntags-wrapper .textntags-tag-list li {
    background-color: #fff;
    padding: 0 5px;
    margin: 0;
    width: auto;
    border-bottom: 1px solid #eee;
    height: 26px;
    line-height: 26px;
    overflow: hidden;
    cursor: pointer;
    list-style: none;
    white-space: nowrap;
}

.textntags-wrapper .textntags-tag-list li:last-child {
    border-radius: 5px;
}

.textntags-wrapper .textntags-tag-list li > img,
.textntags-wrapper .textntags-tag-list li > div.icon {
    width: 16px;
    height: 16px;
    float: left;
    margin-top: 5px;
    margin-right: 5px;
    -moz-background-origin: 3px;
    border-radius: 3px;
}

.textntags-wrapper .textntags-tag-list li em {
    font-weight: bold;
    font-style: none;
}

.textntags-wrapper .textntags-tag-list li:hover,
.textntags-wrapper .textntags-tag-list li.active {
    background-color: #f2f2f2;
}

.textntags-wrapper .textntags-tag-list li b {
    background: #ffff99;
    font-weight: normal;
}

.textntags-wrapper .textntags-beautifier {
    position: relative;
    padding: 11px 10px;
    color: #fff;
    white-space: pre-wrap;
    word-wrap: break-word;
    opacity: 0.3;
}

.textntags-wrapper .textntags-beautifier > div {
    /*color: #fff;*/
    white-space: pre-wrap;
    width: 100%;
    font-family: Arial;
    font-size: 13px;
    line-height: 17px;
}

.textntags-wrapper .textntags-beautifier > div > strong {
    font-weight: normal;
    background: #c38050;
    line-height: 16px;
}

.textntags-wrapper .textntags-beautifier > div > strong > span {
    filter: progid: DXImageTransform.Microsoft.Alpha(opacity=0);
}

.tagged_text {
}
</style>
@endsection

@section("content")
<div class="col-md-6 header-input">
	<div class="form-input">
		<div class="textarea-container">
			<textarea class="tagged_text" placeholder="Bạn đang gặp vấn đề gì?"></textarea>
			<div class="textarea-size"></div>
		</div>
	</div>
	<button class="btn btn-success">Đăng</button>
</div>

@endsection
@section('js')
<script>
	var textContainer, textareaSize, input;
	var autoSize = function() {
	    textareaSize.innerHTML = input.value + '\n';
	};

	document.addEventListener('DOMContentLoaded', function() {
	    textContainer = document.querySelector('.textarea-container');
	    textareaSize = textContainer.querySelector('.textarea-size');
	    input = textContainer.querySelector('textarea');

	    autoSize();
	    input.addEventListener('input', autoSize);
	});

	$.browser = {webkit: true};

$('textarea.tagged_text').textntags( {
    onDataRequest: function(mode, query, triggerChar, callback) {
        var data=<?php echo $userList; ?>;
        query=query.toLowerCase();
        var found=_.filter(data, function(item) {
            return item.name.toLowerCase().indexOf(query) > -1;
        });
        callback.call(this, found);
    }
});
</script>
@endsection