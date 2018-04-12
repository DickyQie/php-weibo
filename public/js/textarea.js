$.fn.extend({
    CurPosition: function(id) {
		var val = $('#'+id).val().length;
        var e = $(this).get(0);
        this.focus();
        if (val === undefined) {
            if (e.selectionStart) {    //FF
                return e.selectionStart;
            }
            if (document.selection) {    //IE
                var rngSel = document.selection.createRange(); //建立选择域
                var rngTxt = e.createTextRange(); //建立文本域
                var flag = rngSel.getBookmark(); //用选择域建立书签
                rngTxt.collapse(); //瓦解文本域到开始位,以便使标志位移动
                rngTxt.moveToBookmark(flag); //使文本域移动到书签位
                rngTxt.moveStart('character', -e.value.length); //获得文本域左侧文本
                str = rngTxt.text.replace(/\r\n/g, '\r'); //替换回车换行符
                return (str.length);
            }
            return e.value.length;
        } else {
            if (e.setSelectionRange) {
                e.setSelectionRange(val, val);
            } else if (e.createTextRange) {
                var range = e.createTextRange();
                range.collapse(true);
                range.moveEnd('character', val);
                range.moveStart('character', val);
                range.select();
            }
        }
    }
});