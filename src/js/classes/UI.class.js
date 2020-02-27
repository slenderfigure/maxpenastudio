class UI {
    static navbarBackgroundColorTransition(ele) {
        let navbar = document.querySelector('.main-nav');

        if (ele.scrollY > 0) {
            navbar.style.backgroundColor = 'rgba(0, 0, 0, 0.7)';
        } else {
            navbar.style.backgroundColor = '#000';
        }
    }
    
    static signupScreen(form) {
        let inputFields = form.querySelectorAll('input');

        if (this.signupFormValidation(inputFields) == true) {
            form.submit(); 
        }         

        inputFields.forEach(input => {
            input.addEventListener('keyup', e => {
                if (e.key != 'Enter') {
                    input.classList.remove('wrong-input');
                    input.nextElementSibling.classList.remove('err-msg-active');
                }
            });
        });
    }

    static signupFormValidation(inputFields) {
        let validated = true;
        
        inputFields.forEach(input => {
            if (!input.value) {
                input.classList.add('wrong-input');
                validated = false;
            }
            
            switch (input.name) {
                case 'fname':
                case 'lname':
                    if (!InputFilter.nameFilter(input.value)) {
                        input.nextElementSibling.classList.add('err-msg-active');
                        validated = false;
                    } 
                    break;
                case 'email':
                    if (!InputFilter.emailFilter(input.value)) {
                        input.nextElementSibling.classList.add('err-msg-active');
                        validated = false;
                    } 
                    break;
                case 'username':
                    if (!InputFilter.usernameFilter(input.value)) {
                        input.nextElementSibling.classList.add('err-msg-active');
                        validated = false;
                    } 
                    break;
                case 'pswrd':
                    if (!InputFilter.passwordFilter(input.value)) {
                        input.nextElementSibling.classList.add('err-msg-active');
                        validated = false;
                    }    
                    break;
                case 're-pswrd':
                    let pswrd = document.querySelector('form[name="signupForm"] input[name="pswrd"]');

                    if (input.value != pswrd.value) {
                        input.nextElementSibling.classList.add('err-msg-active');
                        validated = false;
                    }              
            }
        });

        return validated;
    }

    static logoutConfirmation() {
        let structure = `
        <div class=msg-wrapper>
            <p>Do you want to logout?</p>
        </div>
        <div class="btn-wrapper">
            <button class="cancel-logout">Cancel</button>
            <button class="logout-submit">Log Out</button>
        </div>`;

        let logoutBox = new Messagebox(structure, 'logout');

        logoutBox.displayMessagebox();
        logoutBox.buttonsEvent('cancel-logout', 'logout-submit', () => {
            let myForm = document.querySelector('form[name="logoutForm"]');
            myForm.submit();
        });
    } 

    static goToTheTop(window) {
        let button = document.querySelector('.goup-btn');

        if (button == null) { return; }

        window.scrollY > 200 ? 
        button.classList.add('goto-active') : button.classList.remove('goto-active');
    }

    static autoAdjustTextarea(textarea, dynamic = true) {
        let offset = textarea.offsetHeight - textarea.clientHeight;

        if (dynamic == false) {
            textarea.style.height = `${textarea.scrollHeight + offset}px`;
        }

        textarea.addEventListener('input', () => {
            textarea.style.height = 'auto';
            textarea.style.height = `${textarea.scrollHeight + offset}px`;
        });
    }

    static textareaCharCounter(textarea, counter) {
        textarea.addEventListener('input', e => {
            let currLength = e.target.value.length;
            let remainingChars = 1100;
    
            counter.innerHTML = (remainingChars - currLength) + "/1100";
        });
    }

    static displayEditContols() {
        let editControls = document.querySelectorAll('.editControls');

        /**Display and hide each EditControl Menus */
        this.editControlsActiveStateChanger();

        /**Edit Control Event Listener for each option */
        this.editControlsOptionClickEvent(editControls);
    }

    static editControlsActiveStateChanger() {
        let removeStyling = (ele, className) => {
            ele.classList.remove(className);
        }

        document.querySelectorAll('.postEditBtn').forEach((editBtn, index1) => {
            editBtn.addEventListener('click', () => {
                let editControls = editBtn.nextElementSibling;

                document.querySelectorAll('.postEditBtn').forEach(editBtn => {
                    removeStyling(editBtn, 'postEditBtn-active');
                });
    
                document.querySelectorAll('.editControls').forEach((editControl, index2) => {
                    if (index1 != index2) {
                        removeStyling(editControl, 'editControls-active');
                    }
                });
                
                editBtn.classList.add('postEditBtn-active');
                editControls.classList.toggle('editControls-active');
            });
        });

        // Remove All Styling On Click Outside
        document.addEventListener('click', e => {
            document.querySelectorAll('.editControls').forEach(editControl => {
                if (!e.target.matches('.editControls') &&
                    !e.target.matches('.postEditBtn')) {
                    removeStyling(editControl.previousElementSibling, 'postEditBtn-active');
                    removeStyling(editControl, 'editControls-active');
                }
            });            
        });
    }

    static editControlsOptionClickEvent(editControls) {
        editControls.forEach(editBtn => {
            let article = editBtn.parentElement.parentElement;
            let subject = article.querySelector('.subject').innerHTML;
            let content = article.querySelector('.content').innerHTML; 
            let option1 = editBtn.querySelector('li:first-child');
            let option2 = editBtn.querySelector('li:nth-child(2)');
            let option3 = editBtn.querySelector('li:last-child');
    
            let submitEditForm = (articleId, option, msgBox) => {
                let editForm = document.forms['editForm'];

                editForm['postid'].value = articleId;
                editForm['option'].value = option;

                if (option == 'hide') {
                    msgBox.displayFollowup('You will no longer see this post on your feed.');
                }
                else if (option == 'delete') {
                    msgBox.displayFollowup('Done! Your post was deleted successfully.');
                }
                setTimeout(() => editForm.submit(), 3000);             
            }
            
            option1.addEventListener('click', () => {           
                let structure = `
                <div class="edit-top">
                    <h5>Edit Post</h5>
                    <button class="discard-edit material-icons">&#xe5cd;</button>
                </div>

                <div class=row>
                    <input type="text" name="subject" maxlength="62" form="editForm">
                </div>
                <div class=row>
                    <textarea rows="3" maxlength="1100" 
                    name="content" form="editForm"></textarea>
                </div>
                <div class=row>
                    <button class="btn save-edit">Save</button>
                </div>`;
     
                let editBox = new Messagebox(structure, 'edit');
                editBox.displayMessagebox();
    
                // Load respective article details
                let input     = document.querySelector('.edit input');
                let textarea  = document.querySelector('.edit textarea');
    
                input.value = subject;
                textarea.value = content.replace(/<br>/g, '\r\n');
                UI.autoAdjustTextarea(textarea, false);
    
                editBox.buttonsEvent('discard-edit', 'save-edit', 
                () => submitEditForm(article.id, 'edit'));
            });
    
            option2.addEventListener('click', () => {
                let structure = `
                <div class=msg-wrapper>
                    <p>Hide post from your feed?</p>
                </div>
                <div class="btn-wrapper">
                    <button class="cancel-hide">Cancel</button>
                    <button class="hide-submit">Hide</button>
                </div>`;
                let hideBox = new Messagebox(structure, 'hide');
    
                hideBox.displayMessagebox();
                hideBox.buttonsEvent('cancel-hide', 'hide-submit',
                () => submitEditForm(article.id, 'hide', hideBox));
            });
    
            option3.addEventListener('click', () => {
                let structure = `
                <div class=msg-wrapper>
                    <p>Delete post permanently?</p>
                </div>
                <div class="btn-wrapper">
                    <button class="cancel-delete">Cancel</button>
                    <button class="delete-submit">Delete</button>
                </div>`;
                let deleteBox = new Messagebox(structure, 'delete');
                
                deleteBox.displayMessagebox();
                deleteBox.buttonsEvent('cancel-delete', 'delete-submit', 
                () => submitEditForm(article.id, 'delete', deleteBox));
            });
        });
    }

    static updateProfilePicture() {
        let structure = `
        <form action="db_files/update_profile_pic.php" 
        method="post" enctype="multipart/form-data" name="updateForm"
        id="updateForm">
            <div class="option-wrapper">
                <label class="update-btn">
                    <i class="material-icons">&#xe145;</i>
                    <span>Upload Photo</span>
                    <input type="file" name="propic">
                </label>
            </div>
            <div class="btn-wrapper">
                <button class="cancel-update" type="button">Cancel</button>
            </div>
        </form>`;
        let updateBox = new Messagebox(structure, 'update-wrapper');

        updateBox.displayMessagebox();

        let updateInput = document.forms['updateForm']['propic'];
        
        let showPreview = function (img) {
            let preview = document.createElement('div');
        
            preview.className = 'preview';
            preview.innerHTML = `
            <i class="close-btn material-icons" title="Close">&#xe5cd;</i>

            <img src="${img}" alt="${img}">

            <button type="submit" name="update-submit" value="update"
            form="updateForm">Update</button>
            </div>`;

            return preview;
        }

        updateBox.buttonsEvent('cancel-update');

        updateInput.addEventListener('change', e => {
            let file = Array.from(e.target.files)[0];
            let blob = URL.createObjectURL(file);

            document.querySelector('.update-wrapper').style.display = 'none';
            document.querySelector('.msgbox-overlay').appendChild(showPreview(blob));

            document.querySelector('.close-btn')
            .addEventListener('click', () => {
                document.querySelector('.update-wrapper').style.display = 'block';
                document.querySelector('.preview').remove();
                e.target.value = '';
            });
        });
    }

    static postsLoader(button, offset) {
        let container = document.querySelector('.posts-wrapper');
        let xhl = ServerRequest.createXHL(`php_fn/fn_load_more_posts.php?offset=${offset}`);

        xhl.onload = function () {
            if (this.status == 200) {
                if (this.responseText != "") {
                    button.parentElement.removeChild(button);
                    container.innerHTML += this.responseText;
                    container.appendChild(button);
                    container.parentElement.style.maxHeight = container.parentElement.scrollHeight + "px";
                } else {
                    button.innerHTML = "All caught up!";
                    button.classList.add('load-post-complete');
                }
            }
        }
        xhl.send();
    }
}

// Event: Nav Bar Background Color Transition
window.addEventListener('scroll', () => UI.navbarBackgroundColorTransition(this));

// Event: New Post Textarea Auto Adjust; Char Counter
if (document.querySelector('form[name="postForm"]')) {
    let postForm = document.querySelector('form[name="postForm"]');
    let textarea = postForm.querySelector('textarea');
    let counter  = textarea.nextElementSibling;
    
    UI.autoAdjustTextarea(textarea);
    UI.textareaCharCounter(textarea, counter);
}

// Event: Signup Form
if (document.querySelector('form[name="signupForm"]')) {
    document.querySelector('form[name="signupForm"]')
    .addEventListener('submit', e => {
        e.preventDefault();
        UI.signupScreen(e.target);
    });
}

// Event: Logout Confirmation Message
let navBar = document.querySelector('.main-nav')
.addEventListener('click', e => {
    if (e.target.matches('#logout-submit')) {
        UI.logoutConfirmation();
    }
});

// Event: Back to top
window.addEventListener('scroll', () => UI.goToTheTop(this));

// Event: Posts Edit Controls
if (document.querySelector('.container')) {
    UI.displayEditContols();    
}

// Event: Update Profile Image
if (document.querySelector('.new-posts-wrapper')) {
    document.querySelector('.update-pic-overlay')
    .addEventListener('click', () => UI.updateProfilePicture()); 
}

// Event: Load More Posts
if (document.querySelector('.posts-wrapper')) {
    let offset = 2;
    
    document.querySelector('.load-posts')
    .addEventListener('click', e => {
        UI.postsLoader(e.target, offset);
        offset += 2;
    });
}