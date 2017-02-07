var root_id = 1;

function toggle(source) {
  var checkboxes = document.getElementsByName('designs[]');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
  return get_board_function();
}

function get_board_function(comm = null, num = 1){

  var checkbit = check_checkbox();
  var token = document.getElementById("search_field").value;

  var ul = $('ul.pagination');
  var ul = ul[0];

  if(comm == 'prev')
  {
    if(num == 0)
    {
      return false;
    }

    ul.innerHTML = '';
  }
  else if(comm == 'next')
  {
    if(num%10 != 1)
    {
      return false;
    }

    ul.innerHTML = '';
  }
  $.ajax(
     {
       url: 'database/response_ajax.php',
       type: 'POST',
       data: {
         what: 5,
         checkbit: checkbit,
         token: token,
         page: num
       },
       success:function(data){
         var jsonData = JSON.parse(data);
         document.getElementById("board").innerHTML = jsonData.boardHTML;
         ul.innerHTML = jsonData.indexHTML;
      },
       error:function(data){}
     }
   );
}

function check_checkbox(){
  var sort_method = document.getElementsByName('sort_method');
  var checkboxes = document.getElementsByName('designs[]');
  var double = 1;
  var answer = 0;
  for(var i = 0 ; i < 7 ; i ++){
    if(checkboxes[i].checked){
      answer += double;
    }double *= 2;
  }
  if(sort_method[1].checked){
    answer += double;
  }
  return answer;
}

function add_function(id) {

    $(".addNode_window").remove();
    $(".deleteNode_alertWindow").remove();
    $(".addWindow").remove();

    $('<div class="addWindow"><div class="node_title">[ Insert ]</div><div class="addNo' +
            'de_area"><div class="addNode_title">title</div><input id="addnode_title" type="t' +
            'ext" size="16" maxlength ="10"/></div><div class="addNode_area"><div class="addNode_text">conten' +
            't</div><textarea id="addnode_content" rows="4" cols="15"></textarea></div><div c' +
            'lass="addWindow_addbutton"><button type="button" class="addNode_button" onclick=' +
            '"addNode_function(\'' + id + '\')">ADD</button></div></div>')
        .appendTo(".art")
        .css({
            left: $('.art').width() + $('.art').width() / 3 + 10 + "px",
            top: $('.art').height() - 50 + "px"
        });

}

function addNode_function(id) {

    $.ajax({
        type: 'POST',
        url: 'database/response_ajax.php',
        data: {
            content: document.getElementById("addnode_content").value,
            parent_node_id: id,
            title: document.getElementById("addnode_title").value,
            what: 1
        },
        success: function(data) {
            $(".addNode_window").remove();
            $(".deleteNode_alertWindow").remove();
            $(".addWindow").remove();
            return reset_mindmap();
        },
        error: function(data) {

        }
    });
}

function deleteNode_function(id) {

    $.ajax({
        type: 'POST',
        url: 'database/response_ajax.php',
        data: {
            node_id: id,
            what: 3
        },
        success: function(data) {
            $(".addNode_window").remove();
            $(".deleteNode_alertWindow").remove();
            $(".addWindow").remove();
            if (data == 0) {
                return reset_mindmap();
            } else if (data > 0) {
                $('<div class ="deleteNode_alertWindow"><div class ="deleteNode_alertWindowText">삭제' +
                        ' 할 수 없습니다.<br> 자식 노드 갯수 : ' + data + '</div></div>')
                .appendTo(".art")
                .css({
                    left: $('.art').width() + $('.art').width() / 3 + 10 + "px",
                    top: $('.art').height() - 130 + "px"
                });
            }
        }
    });

}

function reset_mindmap() {

    $.ajax({
        url: 'database/response_ajax.php',
        type: 'POST',
        data: {
            what: 2,
            root_node_id: root_id
        },
        success: function(data) {
            window.location.reload();
        },
        error: function(data) {}
    });

}

function find_root_node_id(board_id) {

    $.ajax({
        url: 'database/response_ajax.php',
        type: 'POST',
        data: {
            what: 4,
            board_id: board_id
        },
        success: function(data) {
            root_id = data;
        },
        error: function(data) {}
    });
}

/*
 js-mindmap
 Copyright (c) 2008/09/10 Kenneth Kufluk http://kenneth.kufluk.com/
 MIT (X11) license
*/

// load the mindmap
$(document).ready(function() {
    // enable the mindmap in the body
    $('.art').mindmap();

    // add the data to the mindmap
    var root = $('.art>ul>li').get(0).mynode = $('.art').addRootNode($('.art>ul>li>a').text(), {
        href: root_id,
        url: '',
        onclick: function(node) {
            $(node.obj.activeNode.content).each(function() {
                this.hide();
            });
        }
    });
    $('.art>ul>li').hide();
    var addLI = function() {
        var parentnode = $(this).parents('li').get(0);
        if (typeof(parentnode) == 'undefined') parentnode = root;
        else parentnode = parentnode.mynode;

        this.mynode = $('.art').addNode(parentnode, $('a:eq(0)', this).text(), {
            //          href:$('a:eq(0)',this).text().toLowerCase(),
            href: $('a:eq(0)', this).attr('href'),
            onclick: function(node) {
                $(node.obj.activeNode.content).each(function() {
                    this.hide();
                });
                $(node.content).each(function() {
                    this.show();
                });
            }
        });
        $(this).hide();
        $('>ul>li', this).each(addLI);
    };
    $('.art>ul>li>ul').each(function() {
        $('>li', this).each(addLI);
    });
});
