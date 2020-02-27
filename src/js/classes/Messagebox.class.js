class Messagebox {
    constructor(structure, className) {
        this.overlay = document.createElement('div');
        this.msgbox  = document.createElement('div');

        this.overlay.className = 'msgbox-overlay';
        this.msgbox.className  = `msgbox ${className}`;
        this.msgbox.innerHTML  = structure;
        this.overlay.appendChild(this.msgbox);
    }

    displayMessagebox() {
        document.body.style.overflow = 'hidden';
        document.body.appendChild(this.overlay);
    }

    displayFollowup(message) {
        let followup = document.createElement('div');

        followup.className = 'msg-followup';
        followup.innerHTML = `
        <p>${message}</p>`;

        this.msgbox.remove();
        setTimeout(() => {
            this.overlay.appendChild(followup);
        }, 1000);
    }

    removeMessagebox() {
        document.body.style.overflow = 'auto';
        this.overlay.style.animation = 'hideMsgOverlay 0.4s ease forwards';
        setTimeout(() => this.overlay.remove(), 400);
    }

    buttonsEvent(button1, button2 = null, callback = null) {
        button1 = document.querySelector(`.${button1}`);
        button2 = document.querySelector(`.${button2}`);

        button1.addEventListener('click', () => {
            this.removeMessagebox();
        });

        document.addEventListener('keyup', e => {
            if (e.key === 'Escape') {
                this.removeMessagebox();
            }
        });

        if (button2 != null) {
            button2.addEventListener('click', () => callback());
        }
    }

    // buttonEvent2(buttons = null) {
    //     if (buttons != null) {
    //         buttons.forEach((button, index) => {
    //             if (index == 0) {
    //                 let button1 = button.mapButton();
    //                 button1.addEventListener('click', () => {
    //                     document.body.style.overflow = 'auto';
    //                     this.overlay.style.animation = 'hideMsgOverlay 0.4s ease forwards';
    //                     setTimeout(() => this.overlay.remove(), 400);
    //                 });
    //             }
    //         });
    //     }
    // }
}