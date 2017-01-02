var options = {
    type: "basic",
    title: "My First Popup with Crhome",
    message: "This is pretty cool",
    icon: ""
}


chrome.notifications.create(options, callback);

function callback(){

}