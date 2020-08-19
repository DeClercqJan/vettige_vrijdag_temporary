import axios from 'axios';


// class maybe better?
export function updateViaContentEditable(tagName, typeId, type, dataAttribute) {
    const htmlCollection = document.getElementsByClassName(tagName);
    const array = Array.from(htmlCollection);
    array.forEach(element => {
        element.addEventListener('input', manageEventListenerOnElement);
    });

    function manageEventListenerOnElement(event) {
        // disable until handled; otherwise too many and incoherent calls
        event.target.removeEventListener('input', manageEventListenerOnElement);
        event.target.addEventListener('focusout', function() {
            // id's of products under the category also change on any change to category. Yet data-attribute of these products don't know this yet. Refreshing on changing of field is simplest solution
            // alternatively, the UpdateCategoryComplexNameOnlyController can return the new Category object, match old and new id's and update data-attributes
            window.location.reload();
        });

        // reset alerts
        const target = document.getElementById('target-template-javascript-contenteditable-name');
        while (target.firstChild) {
            target.removeChild(target.firstChild);
        }

        sendAndHandleRequest(event, target);
    };

    // uses variables of wrapping function (typeId, type) because passing objects via handler function didn't work
    async function sendAndHandleRequest(event, target) {
        const id = event.target.dataset[typeId];
        // prefer textContent over innerHTML
        const name = event.target.textContent;

        try {
            await axios.post(
                `/admin/${type}/${id}/update-name-only-complex`,
                {name: name},
                {headers: {'Content-Type': 'application/json'}},
            )
                .then((result) => {
                    // set new id
                    event.target.setAttribute( dataAttribute, result.data.newId);
                    event.target.addEventListener('input', manageEventListenerOnElement);
                    // handle situation that you've typed faster than calls are handled; how to make sure also the last characters are handled
                    if (name !== event.target.textContent) {
                        manageEventListenerOnElement(event, name, result.data.newId, target);
                    }
                    return result;
                })
                .then((result => {
                    // use html alert alert-success template to display success
                    const temp = document.getElementById("template-javascript-contenteditable-name-success");
                    const messages = Array.from(result.data.messages.success)
                    const clones = [];
                    let i = 0;
                    for (i = 0; i < messages.length; i++) {
                            // console.log(messages[i]);
                            clones[i] = temp.content.cloneNode(true);
                            const p =  clones[i].querySelector('p');
                            p.textContent = messages[i];
                        }
                    clones.forEach(clone => {
                            target.appendChild(clone);
                    });
                    }));
        } catch (err) {
            console.log(err);
            // reactivate old listener on element with old id
            event.target.addEventListener('input', manageEventListenerOnElement);

            // use html alert alert-danger template to display errors
            const temp = document.getElementById("template-javascript-contenteditable-name-error");
            const clone = temp.content.cloneNode(true);
            const p = clone.querySelector('p');
            let errorMessage = '';
            if (err.response.status == '404') {
                errorMessage = err.response.data.detail;
            } else {
                errorMessage = err.response.data;
            }
            p.textContent = errorMessage;
            if (target.children.length > 0) {
                target.replaceChild(clone, target.children[0])
            } else {
                target.appendChild(clone);
            }
        }
    };
};

