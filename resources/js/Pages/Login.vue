<script setup>
import CleanLayout from "../Layouts/CleanLayout.vue";
import { Head, Link, useForm } from '@inertiajs/vue3';
    defineProps({
        message: String,
        errors: Object
    });

  const loginForm = useForm({
        email: '',
        password: ''
    });

    const submit = () => {
        loginForm.post(route('authenticate'));

        loginForm.title = '';
        loginForm.body = '';
    };

</script>
<template>
    <CleanLayout />
    <div class="container-fluid ps-md-0">
        <div class="row g-0">
            <div class="col-md-8 col-lg-6 mx-auto">
                <div class="login d-flex align-items-center py-5">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-9 col-lg-8 mx-auto">
                                <h3 class="login-heading mb-4">Welcome!</h3>

                                <!-- Sign In Form -->
                                <form @submit.prevent="submit">
                                    <div class="mb-3">
                                        <div class="form-floating mb-3">
                                            <input v-model="loginForm.email" type="email" class="form-control" id="floatingInput"
                                                placeholder="name@example.com">
                                            <label for="floatingInput">Email address</label>
                                        </div>
                                        <span v-if="errors.email" className="text-danger">{{ errors.email }}</span>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input v-model="loginForm.password" type="password" class="form-control" id="floatingPassword"
                                            placeholder="Password">
                                        <label for="floatingPassword" class="">Password</label>
                                    </div>
                                    <div class="d-grid">
                                        <button class="btn btn-lg btn-primary btn-login text-uppercase fw-bold mb-2"
                                            type="submit">Sign in</button>
                                        <div class="text-center">
                                            <a class="small" href="#">Forgot password?</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style>
.login {
    min-height: 100vh;
}

.bg-image {
    background-image: url('https://source.unsplash.com/WEQbe2jBg40/600x1200');
    background-size: cover;
    background-position: center;
}

.login-heading {
    font-weight: 300;
}

.btn-login {
    font-size: 0.9rem;
    letter-spacing: 0.05rem;
    padding: 0.75rem 1rem;
}

.form-floating label{

}
</style>



