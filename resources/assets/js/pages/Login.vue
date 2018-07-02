<template>
    <div class="content">

        <h3>Login</h3>
        <hr />
        <form @submit.prevent="submit">
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input
                        type="text"
                        class="form-control"
                        id="exampleInputEmail1"
                        placeholder="Email"
                        name="email"
                        v-validate="{required: true, email: true}"
                        v-model="email"
                >
                <span class="invalid-feedback" style="display: inline-block;" v-if="errors.has('email:required')">Please enter an email address</span>
                <span class="invalid-feedback" style="display: inline-block;" v-if="errors.has('email:email')">Invalid email address format</span>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input
                        type="password"
                        class="form-control"
                        id="exampleInputPassword1"
                        placeholder="Password"
                        v-validate="{required: true}"
                        name="password"
                        v-model="password"
                >
                <span class="invalid-feedback" style="display: inline-block;" v-if="errors.has('password:required')">Please enter a password</span>
            </div>
            <button type="submit" class="btn btn-primary">{{ buttonText }}</button>
            <hr />
            <button type="button" class="btn btn-link">Register</button>
            <button type="button" class="btn btn-link">Reset Password</button>

        </form>

    </div>
</template>

<script>
    import { login } from '../api'
    import { mapActions } from 'vuex'
    import swal from 'sweetalert'

    export default {
      name: 'login',
      data()  {
        return {
          email: '',
          password: '',
          buttonText: 'Login'
        }
      },
      methods: {
        ...mapActions(['login']),
        submit() {
          this.$validator.validateAll()
            .then((result) => {
                if (result) {
                  this.buttonText = 'Logging in....'
                  const payload = {
                    email: this.email,
                    password: this.password
                  }
                  this.login(payload)
                    .then((response) => {
                      swal('Login successful!', '', 'success')
                      this.$router.push({
                        name: 'home'
                      })
                    })
                    .catch((err) => {

                    })
                }
            })
        }
      }
    }
</script>