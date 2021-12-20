<template>
    <div class="container">
        <form class="mt-5" @submit.prevent="onSubmit">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Your link</label>
                <input type="text" :class="{'is-invalid': (v$.link.$error || Object.keys(errors).length > 0)}" v-model.trim="link" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                <div
                    v-for="(error, errorIndex) in v$.link.$errors"
                    :key="errorIndex"
                    class="invalid-feedback"
                >
                    {{ error.$message }}
                </div>
                <div
                    v-for="(error, errorIndex) in errors"
                    :key="errorIndex"
                    class="invalid-feedback"
                >
                    {{ error[0] }}
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <div v-if="generated_link" class="mt-3">
                <a :href="generated_link" target="_blank">{{generated_link}}</a>
            </div>
        </form>
    </div>
</template>

<script>
import { useVuelidate } from '@vuelidate/core'
import { required, url, maxLength } from '@vuelidate/validators'

export default {
    setup () {
        return { v$: useVuelidate() }
    },
    props: [
        'submitUrl',
        'siteUrl',
    ],
    data(){
        return {
            link: '',
            generated_link: '',
            errors: [],
        }
    },
    methods: {
        onSubmit(){
            this.errors = []
            this.generated_link = ''
            this.v$.$validate()
            if (this.v$.$invalid) {
                return false;
            }
            else {
                axios
                    .post(this.submitUrl, {
                        _method: 'PUT',
                        link: this.link
                    })
                    .then((response) => {
                        this.generated_link = this.siteUrl + '/' + response.data.short_link
                    })
                    .catch((error) => {
                        if(error.response && error.response.data.errors){
                            this.errors = error.response.data.errors
                        }
                    });
            }
        }
    },
    validations () {
        return {
            link: {
                required,
                url,
                maxLength: maxLength(255)
            },
        }
    }
}
</script>
