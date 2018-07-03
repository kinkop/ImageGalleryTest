<template>
    <div class="container py-5">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6 mx-auto">
                        <!-- form card login -->
                        <div class="card rounded-0">
                            <div class="card-header">
                                <h3 class="mb-0">Login</h3>
                            </div>
                            <div class="card-body">
                                <form
                                        class="form"
                                        role="form"
                                        autocomplete="off"
                                        id="formLogin"
                                        method="POST"
                                        @submit.prevent="submit"
                                >
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input
                                                type="text"
                                                class="form-control form-control-lg rounded-0"
                                                name="email"
                                                id="email"
                                                v-model="email"
                                                v-validate="{required: true, email: true}"
                                        >
                                        <div
                                                class="invalid-feedback"
                                                style="display: block;"
                                                v-if="errors.has('email:required')">Please enter an email</div>
                                        <div
                                                class="invalid-feedback"
                                                style="display: block;"
                                                v-if="errors.has('email:email')">Invalid email address</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input
                                                type="password"
                                                class="form-control form-control-lg rounded-0"
                                                id="password"
                                                name="password"
                                                v-model="password"
                                                v-validate="{required: true}"
                                        >
                                        <div
                                                class="invalid-feedback"
                                                style="display: block;"
                                                v-if="errors.has('password:required')">Please enter a password</div>
                                    </div>
                                    <button type="button" class="btn btn-default btn-lg float-left">Register</button>
                                    <button type="submit" class="btn btn-success btn-lg float-right">Login</button>
                                </form>
                            </div>
                            <!--/card-block-->
                        </div>
                        <!-- /form card login -->

                    </div>


                </div>
                <!--/row-->

            </div>
            <!--/col-->
        </div>
        <!--/row-->
    </div>
    <!--/container-->
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
                      this.$nextTick(() => {
                        this.$router.push({
                          name: 'root'
                        })
                      })

                    })
                    .catch((err) => {
                        swal('Login not success.', _.get(err, 'response.data.message'), 'error')
                    })
                }
            })
        }
      }
    }
</script>