var messageBoxAcceptFunction = function() {}
var messageBoxCancelFunction = function() {}
var dictElemForDelete;

async function ajaxRequest(url = '', data = {}) {
    console.log(url);
    console.log(data);
    var response = await fetch(url, {
        method: 'POST',
        mode: 'cors', // no-cors, *cors, same-origin
        cache: 'no-cache',
        credentials: 'same-origin',
        headers: {
            'Content-Type': 'application/json'
        },
        redirect: 'follow', // manual, *follow, error
        referrerPolicy: 'no-referrer', // no-referrer, *client
        body: JSON.stringify(data)
    });
    console.log(response.status);
    //if (response.status == 419) location.reload();
    return await response.json();
}

function dictElemSetButtonsToEditMode(parent) {
    parent.querySelector('.editButtonTag').classList.add('zbHidden');
    if (parent.querySelector('.deleteButtonTag')) parent.querySelector('.deleteButtonTag').classList.add('zbHidden');
    parent.querySelector('.confirmButtonTag').classList.remove('zbHidden');
    parent.querySelector('.cancelButtonTag').classList.remove('zbHidden');
}

function dictElemSetButtonsToViewMode(parent) {
    parent.querySelector('.editButtonTag').classList.remove('zbHidden');
    if (parent.querySelector('.deleteButtonTag')) parent.querySelector('.deleteButtonTag').classList.remove('zbHidden');
    parent.querySelector('.confirmButtonTag').classList.add('zbHidden');
    parent.querySelector('.cancelButtonTag').classList.add('zbHidden');
}

function dictElemBeginEditClick(parent) {
    if (!parent) return;
    dictElemSetButtonsToEditMode(parent);
    let input = parent.querySelector('.descriptionInputTag');
    input.disabled=false;
    input.dataset.previousValue = input.value;
    input = parent.querySelector('.nameInputTag');
    input.disabled=false;
    input.dataset.previousValue = input.value;
    input.focus();
}

function dictElemCancelEditClick(parent) {
    if (!parent) return;
    dictElemCancelEdit(parent);
}

function dictElemCancelEdit(parent) {
    let input = parent.querySelector('.nameInputTag');
    let oldValue = input.dataset.previousValue;
    input.setAttribute('value', oldValue);
    input.value = oldValue;
    input.disabled=true;
    input = parent.querySelector('.descriptionInputTag');
    oldValue = input.dataset.previousValue;
    input.setAttribute('value', oldValue);
    input.value = oldValue;
    input.disabled=true;
    dictElemSetButtonsToViewMode(parent);
}

function dictElemDeleteClick(parent) {
    if (!parent) return;
    dictElemForDelete = parent;
    let nameValue = parent.querySelector('.nameInputTag').value;
    showConfirmBox('dictElemDelete', nameValue);
}

function dictElemDelete() {
    let parent = dictElemForDelete;
    ajaxRequest('api/dictelemdelete.php', { className: className, dictElemId: parent.dataset.dictElemId })
    .then((data) => {
        console.log(data);
        if (!data.success) {
            showMessageBox(data.message);
        } else {
            parent.remove();
        }
    });
}

function dictElemConfirmChangesClick(parent) {
    if (!parent) return;
    let inputName = parent.querySelector('.nameInputTag');
    let inputDescription = parent.querySelector('.descriptionInputTag');
    if ((inputName.value == inputName.dataset.previousValue) && (inputDescription.value == inputDescription.dataset.previousValue)) {
        dictElemCancelEdit(parent);
        return;
    }
    if (inputName.value == '') {
        showMessageBox('Для повного видалення елементу скористайтесь кнопкою видалення. Елементи, які вже у використанні, видалити неможна.');
        dictElemCancelEdit(parent);
        return;
    }
    dictElemSetButtonsToViewMode(parent);
    inputName.disabled=true;
    inputDescription.disabled=true;
    ajaxRequest('api/dictelemupdate.php', { className: className, nameValue: inputName.value, descriptionValue: inputDescription.value, dictElemId: parent.dataset.dictElemId })
    .then((data) => {
        console.log(data);
        if (!data.success) {
            showMessageBox(data.message);
        } else {
            showMessageBox('Збережено');
        }
    });
}

function showConfirmBox(messageId = 0, customText = '') {
    if (messageId == 0) return;
    let elem = document.getElementById('messageBoxText');
    if (messageId == 'dictElemDelete') {
    elem.innerHTML = 'Ви дійсно бажаєте видалити елемент довідника "'+customText+'"?';
    messageBoxAcceptFunction = dictElemDelete;
    }
    
    elem = document.getElementById('messageBox');
    elem.style.display = "flex";
}

function showMessageBox(message) {
    if (!message) return;
    let elem = document.getElementById('messageBoxOneButtonText');
    elem.innerHTML = message;
    elem = document.getElementById('messageBoxOneButton');
    elem.style.display = "flex";
}

function messageBoxAcceptClick() {
    elem = document.getElementById('messageBox');
    elem.style.display = "none";
    messageBoxAcceptFunction();
}

function messageBoxCancelClick() {
    elem = document.getElementById('messageBox');
    elem.style.display = "none";
    messageBoxCancelFunction();
}

console.log('js script loaded successfully');