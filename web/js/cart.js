(function (){

    $("input[class='qty']").blur(function (e) {
        e.preventDefault();
        $this = $(this);
        var value = $this.val();
         $.ajax({
            url: $this.attr("data-path"),
            method: "POST",
            data: {
                id : $this.attr("id"),
                action : $this.attr("data-action"),
                no : value
            },
            dataType: "json"
        })
          .done(function (rep) {
             
             if (rep.granted) {
                console.log("seccuss");
                }
            })
         
    });


    $('.cart-action-button').click(function (e) {
        e.preventDefault();
        $this = $(this);
        $("#loading").css("display", "block");
        var value = $("#" + $this.attr("data-id")).val();
        if ($this.attr("class") == "number-input number-input-up cart-action-button" ) {
            if ( value <= 99 ) {
                var newVal = parseFloat(value) + 1;
            } 
            } 
        else if ($this.attr("class") == "number-input number-input-down cart-action-button") {
            if (value > 1) {
            var newVal = parseFloat(value) - 1;
            $this.css("display", "block");
            } else {
                $this.css("display", "none");
                newVal = 1;
            
            }
        }
        $.ajax({
            url: $this.attr("data-path"),
            method: "POST",
            data: {
                id : $this.attr("data-id"),
                action : $this.attr("data-action"),
                no : $this.attr("data-no")
            },
            dataType: "json"
        })
        .done(function (rep) {
                if (rep.granted) {
                        $("#" + $this.attr("data-id")).val(newVal);                
                }
                else {
                    location.reload(true);
                    alert(": (");
                }
            $("#loading").css("display", "none");
        })
    })
})();

function selectAll(source) {
  var checkboxes = document.getElementsByName('product-id[]');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}