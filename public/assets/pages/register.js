document.addEventListener("DOMContentLoaded", () => {
    const $form = document.querySelector("form");
    const $emailError = document.querySelector(".email-error");
    const $verifyError = document.querySelector(".verify-error");
    const $email = document.querySelector("#email");
    const $email_repeat = document.querySelector("#email_repeat");

    const getValidations = ({email, email_repeat}) => {
        let emailIsValid = false;
        let emailsMatch = false;

        if (email !== "" && /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
            emailIsValid = true;
        }
        
        if (email === email_repeat) {
            emailsMatch = true;
        }
        
        return {
            emailIsValid,
            emailsMatch,
        };
    };
    
    
    $form.addEventListener("submit", (e) => {
        e.preventDefault();
        // console.log(e.target.elements.email.value);
        // console.log(e.target.elements.email_repeat.value);
        const { email, email_repeat} = e.target.elements;
        const values = {
            email: email.value,
            email_repeat: email_repeat.value,
        };

        const validations = getValidations(values);

        if (!validations.emailIsValid) {
            $emailError.classList.remove("hide");
        } else {
            $emailError.classList.add("hide");
        }

        if (!validations.emailsMatch) {
            $verifyError.classList.remove("hide");
        } else {
            $verifyError.classList.add("hide");
        }

        if (validations.emailIsValid && validations.emailsMatch ) {
            $form.submit();
        }

    })

} );