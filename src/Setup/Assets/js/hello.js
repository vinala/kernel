$(document).ready(function() {
    function e() {
        $("#content").fadeTo("slow", 1), clearInterval(s)
    }

    function t() {
        $({
            blurRadius: 0
        }).animate({
            blurRadius: 5
        }, {
            duration: 600,
            easing: "linear",
            step: function() {
                $("#bg").css({
                    "-webkit-filter": "blur(" + this.blurRadius + "px)",
                    filter: "blur(" + this.blurRadius + "px)"
                })
            }
        }), clearInterval(Timer0)
    }

    function n() {
        $("#bottom_panel").fadeTo("slow", 1), $("#bottom_panel_2").fadeTo("slow", 1), $("#bottom_owner").fadeTo("slow", 1), $("#bottom_docs").fadeTo("slow", 1), clearInterval(r)
    }

    function o() {
        $("#hello_logo").fadeTo("slow", 1), clearInterval(Timer3)
    }

    function f() {
        $("#welcom").fadeTo("slow", 1), clearInterval(u)
    }

    function z() 
    {
        $("#vnl_config_icon").animate({marginTop:"140" , width: "250" , height : "95"});
    }


    var s, r, u;
    Timer0 = setInterval(function() {
        t()
    }, 200), s = setInterval(function() {
        e()
    }, 400), $("#vnl-config-msg-form").submit(function() {
        return $("#fst_db_msg_step").fadeOut(300, function() {
            $("#fst_glob_conf_step").fadeIn(300)
        }), !1
    }), 
    $("#nxt_to_glob").click(function() {
        return $("#fst_pass_msg_step").fadeOut(300, function() {
            $("#fst_glob_conf_step").fadeIn(300)
        }), !1
    }), $("#vnl-glob-db-form").submit(function() {
        return $.post("hello/set_glob", $("#vnl-glob-db-form").serialize(), function(e) {
            "true" == e ? (document.getElementById("dev_nom").innerHTML = document.getElementById("dev_name").value, $("#fst_glob_conf_step").fadeOut(300, function() {
                z();
                Timer3 = setInterval(function() {
                    o()
                }, 200), u = setInterval(function() {
                    f()
                }, 400), r = setInterval(function() {
                    n()
                }, 800)

            })) : alert("Un erreur est survenue")
        }), !1
    })
});