<template>
    <main class="main">
        <div class="auth">
            <div class="auth__img">
                <img src="auth.jpg" alt="Авторизация БИФК | Расписание" />
            </div>
            <div class="auth__form">
                <h3 class="auth__title">Авторизация</h3>
                <form action="" method="post" @submit.prevent="this.submitForm">
                    <div class="input-wrap">
                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="auth__input"
                            autocomplete="off"
                            placeholder="Email"
                            v-model="this.form.email"
                            required
                        />
                        <label class="auth__label" for="email">Email:</label>
                        <div class="auth__icon">
                            <svg
                                enable-background="new 0 0 100 100"
                                version="1.1"
                                viewBox="0 0 100 100"
                                xml:space="preserve"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <g transform="translate(0 -952.36)">
                                    <path
                                        d="m17.5 977c-1.3 0-2.4 1.1-2.4 2.4v45.9c0 1.3 1.1 2.4 2.4 2.4h64.9c1.3 0 2.4-1.1 2.4-2.4v-45.9c0-1.3-1.1-2.4-2.4-2.4h-64.9zm2.4 4.8h60.2v1.2l-30.1 22-30.1-22v-1.2zm0 7l28.7 21c0.8 0.6 2 0.6 2.8 0l28.7-21v34.1h-60.2v-34.1z"
                                    ></path>
                                </g>
                                <rect
                                    class="st0"
                                    width="100"
                                    height="100"
                                ></rect>
                            </svg>
                        </div>
                    </div>
                    <div class="input-wrap">
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="auth__input"
                            autocomplete="off"
                            placeholder="Пароль"
                            v-model="this.form.password"
                        />
                        <label class="auth__label" for="password"
                            >Пароль:</label
                        >
                        <div class="auth__icon">
                            <svg
                                enable-background="new 0 0 24 24"
                                version="1.1"
                                viewBox="0 0 24 24"
                                xml:space="preserve"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <rect class="st0" width="24" height="24"></rect>
                                <path
                                    class="st1"
                                    d="M19,21H5V9h14V21z M6,20h12V10H6V20z"
                                ></path>
                                <path
                                    class="st1"
                                    d="M16.5,10h-1V7c0-1.9-1.6-3.5-3.5-3.5S8.5,5.1,8.5,7v3h-1V7c0-2.5,2-4.5,4.5-4.5s4.5,2,4.5,4.5V10z"
                                ></path>
                                <path
                                    class="st1"
                                    d="m12 16.5c-0.8 0-1.5-0.7-1.5-1.5s0.7-1.5 1.5-1.5 1.5 0.7 1.5 1.5-0.7 1.5-1.5 1.5zm0-2c-0.3 0-0.5 0.2-0.5 0.5s0.2 0.5 0.5 0.5 0.5-0.2 0.5-0.5-0.2-0.5-0.5-0.5z"
                                ></path>
                            </svg>
                        </div>
                    </div>
                    <ul>
                        <li v-for="error in this.errors">
                            {{ error }}
                        </li>
                    </ul>
                    <button type="submit" class="auth__btn">Войти</button>
                </form>
            </div>
        </div>
    </main>
</template>

<script>
import axios from "axios";
export default {
    data() {
        return {
            form: {
                email: "",
                password: "",
            },
            errors: null,
        };
    },
    methods: {
        submitForm() {
            axios
                .post("", {
                    email: this.form.email,
                    password: this.form.password,
                })
                .then((res) => {
                    window.location.href = res.data;
                })
                .catch((res) => {
                    console.log(res.response);
                    this.errors = res.response.data.message;
                });
        },
    },
};
</script>

<style lang="scss" scoped>
.main {
    width: 100%;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: #1d1e23;
}
.auth {
    max-width: 650px;
    display: flex;
    overflow: hidden;
    border-radius: 15px;
    &__img {
        width: 40%;
        overflow: hidden;
        img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    }
    &__form {
        width: 60%;
        background: #fff;
        display: flex;
        justify-content: center;
        flex-direction: column;
        padding: 0 45px;
        text-align: center;
    }
    &__title {
        font-size: 1.5rem;
        letter-spacing: 2px;
        margin-bottom: 20px;
    }
    .input-wrap {
        position: relative;
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    &__input {
        display: block;
        width: calc(100% - 44px);
        height: 56px;
        border: none;
        outline: none;
        padding: 20px 0;
        font-size: 16px;
        margin-left: auto;
        border-bottom: 1px solid var(--border-color);
        &:focus {
            border-bottom: 1px solid var(--first-color-alt);
        }
    }
    &__icon {
        position: absolute;
        top: 0;
        left: 0;
        width: 44px;
        height: 56px;
        display: flex;
        opacity: 0.15;
        svg {
            width: 30px;
            height: 30px;
            margin: auto;
            fill: none;
            path {
                fill: #000;
            }
        }
    }
    &__label {
        position: absolute;
        top: calc(50% - 7px);
        left: 0;
        opacity: 0;
        transition: all 0.3s ease;
        padding-left: 44px;
        font-size: 12.5px;
    }
    &__input:not(:placeholder-shown) {
        padding: 28px 0px 12px 0px;
    }
    &__input:not(:placeholder-shown) + &__label {
        transform: translateY(-12px);
        opacity: 0.7;
    }
    &__input:valid:not(:placeholder-shown) {
        border-bottom: 1px solid var(--first-color-alt) !important;
    }
    &__input:valid:not(:placeholder-shown) + &__label + &__icon {
        opacity: 1;
        svg {
            path {
                fill: var(--first-color-alt);
            }
        }
    }
    &__input:not(:valid):not(:focus) + &__label + &__icon {
        animation-name: shake-shake;
        animation-duration: 0.3s;
    }
    &__btn {
        width: auto;
        min-width: 100px;
        border-radius: 24px;
        text-align: center;
        padding: 15px 40px;
        margin-top: 20px;
        // background-color: #b08bf8;
        background-color: var(--first-color-alt);
        color: #fff;
        font-size: 14px;
        margin-left: auto;
        font-weight: 500;
        box-shadow: 0px 2px 6px -1px rgba(0, 0, 0, 0.13);
        border: none;
        transition: all 0.3s ease;
        outline: 0;
        cursor: pointer;
    }
    $displacement: 3px;
    @keyframes shake-shake {
        0% {
            transform: translateX(-$displacement);
        }
        20% {
            transform: translateX($displacement);
        }
        40% {
            transform: translateX(-$displacement);
        }
        60% {
            transform: translateX($displacement);
        }
        80% {
            transform: translateX(-$displacement);
        }
        100% {
            transform: translateX(0px);
        }
    }
    input:-webkit-autofill {
        -webkit-background-clip: text;
    }
}
@media screen and (max-width: 670px) {
    .auth {
        &__img {
            display: none;
        }
        &__form {
            width: 100%;
            padding: 45px;
        }
        &__title {
            font-size: 17px;
        }
    }
}
</style>
