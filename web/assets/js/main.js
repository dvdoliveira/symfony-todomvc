(function() {

  $(document).ready(function() {
    var allRemovableItems;
    var refreshElementRemaining;
    var refreshElementToDelete;
    $("input:text:visible:first").focus();
    allRemovableItems = 0;
    refreshElementRemaining = function() {
      var allCompletedItems;
      allCompletedItems = $("li:not(.completed) ").length;
      return $('#elementsRemaining').html(allCompletedItems);
    };
    refreshElementToDelete = function() {
      this.allRemovableItems = $(".completed").length;
      return $('#clear-completed ').html("Clear completed (" + this.allRemovableItems + ")");
    };
    refreshElementRemaining();
    refreshElementToDelete();
    
    $('.btnedit').click(function() {
      var item;
      var todoid;
      var url;
      item = this;
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
            $(item).parents("li").removeClass("completed");
          } else {
            $('.toggle').checked = "yes";
            $(item).parents("li").addClass("completed");
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
