var messageBoxAcceptFunction = function() {}
var messageBoxCancelFunction = function() {}
var dictElemForDelete;
var productIdForDelete;

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
    document.getElementById("addDictElemButton").disabled = true;
    parent.querySelector('.descriptionInputTag').disabled = false;
    parent.querySelector('.nameInputTag').disabled = false;
}

function dictElemSetButtonsToViewMode(parent) {
    parent.querySelector('.editButtonTag').classList.remove('zbHidden');
    if (parent.querySelector('.deleteButtonTag')) parent.querySelector('.deleteButtonTag').classList.remove('zbHidden');
    parent.querySelector('.confirmButtonTag').classList.add('zbHidden');
    parent.querySelector('.cancelButtonTag').classList.add('zbHidden');
    document.getElementById("addDictElemButton").disabled = false;
    parent.querySelector('.descriptionInputTag').disabled = true;
    parent.querySelector('.nameInputTag').disabled = true;
    parent.querySelector('.descriptionInputTag').classList.remove('is-invalid');
    parent.querySelector('.nameInputTag').classList.remove('is-invalid');
}

function dictElemBeginEditClick(parent) {
    if (!parent) return;
    dictElemSetButtonsToEditMode(parent);
    let input = parent.querySelector('.descriptionInputTag');
    input.dataset.previousValue = input.value;
    input = parent.querySelector('.nameInputTag');
    input.dataset.previousValue = input.value;
    input.focus();
}

function dictElemCancelEditClick(parent) {
    if (!parent) return;
    dictElemCancelEdit(parent);
}

function dictElemCancelEdit(parent) {
    let inputName = parent.querySelector('.nameInputTag');
    let oldValueName = inputName.dataset.previousValue;
    let inputDescription = parent.querySelector('.descriptionInputTag');
    let oldValueDescription = inputDescription.dataset.previousValue;
    if ((oldValueName == '') && (oldValueDescription == '')) {
        parent.remove();
        document.getElementById("addDictElemButton").disabled = false;
        return;
    }
    inputName.setAttribute('value', oldValueName);
    inputName.value = oldValueName;
    inputDescription.setAttribute('value', oldValueDescription);
    inputDescription.value = oldValueDescription;
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
    ajaxRequest('API/dictelemdelete.php', { className: className, dictElemId: parent.dataset.dictElemId })
    .then((data) => {
        console.log(data);
        if (!data.success) {
            showMessageBox(data.message);
        } else {
            parent.remove();
        }
    });
}

function productDeleteClick(productId) {
    if (typeof productId != 'number') return;
    if (productId < 0) return;
    productIdForDelete = productId;
    // Тут має бути логіка обробки того, що саме підлягає видаленню - існуючий товар, або щойно створений.
    showConfirmBox('productDelete');
}

function productDelete() {
    ajaxRequest('API/productdelete.php', { productId: productIdForDelete })
    .then((data) => {
        console.log(data);
        if (!data.success) {
            showMessageBox(data.message);
        } else {
            document.location=(document.getElementById("backLink").href);
        }
    });
}

function dictElemAddClick() {
    parentContainer = document.getElementById("dictionaryElementsContainer");
    let newDictElem = document.createElement('div');
    maxId++; // Це лише для збереження унікальності id DOM-елементів. Для id в базі він не застосовується, оскільки може втратити актуальність впродовж редагування.
	newDictElem.classList.add('columnGap15');
    newDictElem.classList.add('canWrap');
    newDictElem.classList.add('fullWidthContainer');
    newDictElem.dataset.dictElemId = 0; // Це як раз id редагування, або, в даному випадку, - створення.
    newDictElem.innerHTML =
        '<div class="propertySelectGroup"><div class="input-group"><span class="input-group-text">Назва:</span>'+
        '<input disabled type="text" value="" class="form-control nameInputTag" data-elem-id="'+maxId+'">'+
        '<div class="invalid-feedback" id="nameError'+maxId+'">Текст помилки</div></div></div>'+
        '<div class="propertySelectGroup"><div class="input-group"><span class="input-group-text">Опис:</span>'+
        '<input disabled type="text" value="" class="form-control descriptionInputTag" data-elem-id="'+maxId+'">'+
        '<div class="invalid-feedback" id="descriptionError'+maxId+'">Текст помилки</div></div></div>'+
        '<button class="btn btn-outline-primary editButtonTag" type="button" onclick="dictElemBeginEditClick(this.parentElement);">Редагувати</button>'+
        '<button class="btn btn-outline-danger deleteButtonTag" type="button" onclick="dictElemDeleteClick(this.parentElement);">Видалити</button>'+
        '<button class="btn btn-primary zbHidden confirmButtonTag" type="button" onclick="dictElemConfirmChangesClick(this.parentElement);">Зберегти</button>'+
        '<button class="btn btn-primary zbHidden cancelButtonTag" type="button" onclick="dictElemCancelEditClick(this.parentElement);">Скасувати</button>';
    parentContainer.appendChild(newDictElem);
    dictElemBeginEditClick(newDictElem);
}

function dictElemConfirmChangesClick(parent) {
    if (!parent) return;
    let inputName = parent.querySelector('.nameInputTag');
    let inputDescription = parent.querySelector('.descriptionInputTag');
    if (inputName.value == '') {
        errorElement = document.getElementById("nameError"+inputName.dataset.elemId);
        errorElement.innerHTML = 'Це обовʼязкове поле';
        inputName.classList.add("is-invalid");
        //showMessageBox('Для повного видалення елементу скористайтесь кнопкою видалення. Елементи, які вже у використанні, видалити неможна.');
        return;
    }
    if ((inputName.value == inputName.dataset.previousValue) && (inputDescription.value == inputDescription.dataset.previousValue)) {
        dictElemCancelEdit(parent);
        return;
    }
    ajaxRequest('API/dictelemupdate.php', { className: className, nameValue: inputName.value, descriptionValue: inputDescription.value, dictElemId: parent.dataset.dictElemId })
    .then((data) => {
        console.log(data);
        if (!data.success) {
            showMessageBox(data.message);
        } else {
            parent.dataset.dictElemId = data.id;
            dictElemSetButtonsToViewMode(parent);
            showMessageBox('Збережено');
        }
    });
}

function checkValue(elem) {
    if (elem.value && (elem.value != '')) elem.classList.remove('is-invalid');
}

function showConfirmBox(messageId = 0, customText = '') {
    if (messageId == 0) return;
    let elem = document.getElementById('messageBoxText');
    if (messageId == 'dictElemDelete') {
        elem.innerHTML = 'Ви дійсно бажаєте видалити елемент довідника "'+customText+'"?';
        messageBoxAcceptFunction = dictElemDelete;
    }
    if (messageId == 'productDelete') {
        elem.innerHTML = 'Ви дійсно бажаєте повністю видалити картку товара?';
        messageBoxAcceptFunction = productDelete;
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