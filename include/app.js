var data = {
    show: {
      loader: true,
      start: false,
    },
  }
  
var app = new Vue({
    el: '#app',
    data: data,
    methods: {
    showComponent: function(comp){
        //makes component defined in parameter visible
        data.show[comp] = true
    },
    hideComponent: function(comp){
        //makes component defined in parameter hidden
        if (comp == 'all'){
        var x
        for (x in data.show){
            data.show[x] = false
        }
        } else {
        data.show[comp] = false
        }
    },
    showAlert: function(msg){
        //shows or changes alert banner with message defined in parameter, red background
        $( "#alert" ).html("<div class='alert alert-danger alert-dismissible fade show'><button type='button' class='close' data-dismiss='alert'>&times;</button>"+msg+"</div><br>");
    },
    showNotice: function(msg){
        //shows yellow alert banner with message defined in parameter, yellow background
        $( "#alert" ).html("<div class='alert alert-success alert-dismissible fade show'><button type='button' class='close' data-dismiss='alert'>&times;</button>"+msg+"</div><br>");
    },
    closeAlert: function(){
        //closes alert banner
        $( "#alert" ).html("");
    },
    isIE: function() {
        //returns true if browser is IE
        const ua = window.navigator.userAgent; //Check the userAgent property of the window.navigator object
        const msie = ua.indexOf('MSIE '); // IE 10 or older
        const trident = ua.indexOf('Trident/'); //IE 11
    
        return (msie > 0 || trident > 0);
    },
    },
    mounted: function() {
        //on load hides all components (e.g. loader) and shows the start view
        console.log('app mounted')
        this.hideComponent('all')
        this.showComponent('start')
    }
})