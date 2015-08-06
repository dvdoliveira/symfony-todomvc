(function() {

  $(document).ready(function() {
    var refreshElementRemaining;
    var refreshElementToDelete;
    
    $('.btnedit').click(function() {
      var todo;
      var todoid;
      var url;
      todo = this;
      todoid = $(this).data("todoid");
      url = Routing.generate("todo_update", {
        id: todoid
      });

      return $.ajax(url, {
        type: "POST",
        contentType: "application/json",
        success: function(data) {
          if (data.completed === 0) {
            $('.toggle').checked = null;
            $(todo).parents("li").removeClass("completed");
          } else {
            $('.toggle').checked = "yes";
            $(todo).parents("li").addClass("completed");
          }
          refreshElementRemaining();
          return refreshElementToDelete();
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status);
          return alert(thrownError);
        }
      });
    });
    return $('#toggle-all').on("click", function() {
      return $('#formtoggle').submit();
    });
  });

}).call(this);
