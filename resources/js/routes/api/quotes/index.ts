import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Api\QuoteController::pdf
* @see app/Http/Controllers/Api/QuoteController.php:81
* @route '/api/quotes/{quote}/pdf'
*/
export const pdf = (args: { quote: string | number | { id: string | number } } | [quote: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: pdf.url(args, options),
    method: 'get',
})

pdf.definition = {
    methods: ["get","head"],
    url: '/api/quotes/{quote}/pdf',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Api\QuoteController::pdf
* @see app/Http/Controllers/Api/QuoteController.php:81
* @route '/api/quotes/{quote}/pdf'
*/
pdf.url = (args: { quote: string | number | { id: string | number } } | [quote: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { quote: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { quote: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            quote: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        quote: typeof args.quote === 'object'
        ? args.quote.id
        : args.quote,
    }

    return pdf.definition.url
            .replace('{quote}', parsedArgs.quote.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Api\QuoteController::pdf
* @see app/Http/Controllers/Api/QuoteController.php:81
* @route '/api/quotes/{quote}/pdf'
*/
pdf.get = (args: { quote: string | number | { id: string | number } } | [quote: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: pdf.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Api\QuoteController::pdf
* @see app/Http/Controllers/Api/QuoteController.php:81
* @route '/api/quotes/{quote}/pdf'
*/
pdf.head = (args: { quote: string | number | { id: string | number } } | [quote: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: pdf.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Api\QuoteController::pdf
* @see app/Http/Controllers/Api/QuoteController.php:81
* @route '/api/quotes/{quote}/pdf'
*/
const pdfForm = (args: { quote: string | number | { id: string | number } } | [quote: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: pdf.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Api\QuoteController::pdf
* @see app/Http/Controllers/Api/QuoteController.php:81
* @route '/api/quotes/{quote}/pdf'
*/
pdfForm.get = (args: { quote: string | number | { id: string | number } } | [quote: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: pdf.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Api\QuoteController::pdf
* @see app/Http/Controllers/Api/QuoteController.php:81
* @route '/api/quotes/{quote}/pdf'
*/
pdfForm.head = (args: { quote: string | number | { id: string | number } } | [quote: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: pdf.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

pdf.form = pdfForm

/**
* @see \App\Http\Controllers\Api\QuoteController::index
* @see app/Http/Controllers/Api/QuoteController.php:24
* @route '/api/quotes'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/api/quotes',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Api\QuoteController::index
* @see app/Http/Controllers/Api/QuoteController.php:24
* @route '/api/quotes'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Api\QuoteController::index
* @see app/Http/Controllers/Api/QuoteController.php:24
* @route '/api/quotes'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Api\QuoteController::index
* @see app/Http/Controllers/Api/QuoteController.php:24
* @route '/api/quotes'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Api\QuoteController::index
* @see app/Http/Controllers/Api/QuoteController.php:24
* @route '/api/quotes'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Api\QuoteController::index
* @see app/Http/Controllers/Api/QuoteController.php:24
* @route '/api/quotes'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Api\QuoteController::index
* @see app/Http/Controllers/Api/QuoteController.php:24
* @route '/api/quotes'
*/
indexForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

index.form = indexForm

/**
* @see \App\Http\Controllers\Api\QuoteController::store
* @see app/Http/Controllers/Api/QuoteController.php:52
* @route '/api/quotes'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/api/quotes',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Api\QuoteController::store
* @see app/Http/Controllers/Api/QuoteController.php:52
* @route '/api/quotes'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Api\QuoteController::store
* @see app/Http/Controllers/Api/QuoteController.php:52
* @route '/api/quotes'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Api\QuoteController::store
* @see app/Http/Controllers/Api/QuoteController.php:52
* @route '/api/quotes'
*/
const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Api\QuoteController::store
* @see app/Http/Controllers/Api/QuoteController.php:52
* @route '/api/quotes'
*/
storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

store.form = storeForm

/**
* @see \App\Http\Controllers\Api\QuoteController::show
* @see app/Http/Controllers/Api/QuoteController.php:62
* @route '/api/quotes/{quote}'
*/
export const show = (args: { quote: string | number | { id: string | number } } | [quote: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/api/quotes/{quote}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Api\QuoteController::show
* @see app/Http/Controllers/Api/QuoteController.php:62
* @route '/api/quotes/{quote}'
*/
show.url = (args: { quote: string | number | { id: string | number } } | [quote: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { quote: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { quote: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            quote: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        quote: typeof args.quote === 'object'
        ? args.quote.id
        : args.quote,
    }

    return show.definition.url
            .replace('{quote}', parsedArgs.quote.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Api\QuoteController::show
* @see app/Http/Controllers/Api/QuoteController.php:62
* @route '/api/quotes/{quote}'
*/
show.get = (args: { quote: string | number | { id: string | number } } | [quote: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Api\QuoteController::show
* @see app/Http/Controllers/Api/QuoteController.php:62
* @route '/api/quotes/{quote}'
*/
show.head = (args: { quote: string | number | { id: string | number } } | [quote: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Api\QuoteController::show
* @see app/Http/Controllers/Api/QuoteController.php:62
* @route '/api/quotes/{quote}'
*/
const showForm = (args: { quote: string | number | { id: string | number } } | [quote: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Api\QuoteController::show
* @see app/Http/Controllers/Api/QuoteController.php:62
* @route '/api/quotes/{quote}'
*/
showForm.get = (args: { quote: string | number | { id: string | number } } | [quote: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Api\QuoteController::show
* @see app/Http/Controllers/Api/QuoteController.php:62
* @route '/api/quotes/{quote}'
*/
showForm.head = (args: { quote: string | number | { id: string | number } } | [quote: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

show.form = showForm

/**
* @see \App\Http\Controllers\Api\QuoteController::update
* @see app/Http/Controllers/Api/QuoteController.php:67
* @route '/api/quotes/{quote}'
*/
export const update = (args: { quote: string | number | { id: string | number } } | [quote: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put","patch"],
    url: '/api/quotes/{quote}',
} satisfies RouteDefinition<["put","patch"]>

/**
* @see \App\Http\Controllers\Api\QuoteController::update
* @see app/Http/Controllers/Api/QuoteController.php:67
* @route '/api/quotes/{quote}'
*/
update.url = (args: { quote: string | number | { id: string | number } } | [quote: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { quote: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { quote: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            quote: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        quote: typeof args.quote === 'object'
        ? args.quote.id
        : args.quote,
    }

    return update.definition.url
            .replace('{quote}', parsedArgs.quote.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Api\QuoteController::update
* @see app/Http/Controllers/Api/QuoteController.php:67
* @route '/api/quotes/{quote}'
*/
update.put = (args: { quote: string | number | { id: string | number } } | [quote: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\Api\QuoteController::update
* @see app/Http/Controllers/Api/QuoteController.php:67
* @route '/api/quotes/{quote}'
*/
update.patch = (args: { quote: string | number | { id: string | number } } | [quote: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Api\QuoteController::update
* @see app/Http/Controllers/Api/QuoteController.php:67
* @route '/api/quotes/{quote}'
*/
const updateForm = (args: { quote: string | number | { id: string | number } } | [quote: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Api\QuoteController::update
* @see app/Http/Controllers/Api/QuoteController.php:67
* @route '/api/quotes/{quote}'
*/
updateForm.put = (args: { quote: string | number | { id: string | number } } | [quote: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Api\QuoteController::update
* @see app/Http/Controllers/Api/QuoteController.php:67
* @route '/api/quotes/{quote}'
*/
updateForm.patch = (args: { quote: string | number | { id: string | number } } | [quote: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

update.form = updateForm

/**
* @see \App\Http\Controllers\Api\QuoteController::destroy
* @see app/Http/Controllers/Api/QuoteController.php:74
* @route '/api/quotes/{quote}'
*/
export const destroy = (args: { quote: string | number | { id: string | number } } | [quote: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/api/quotes/{quote}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Api\QuoteController::destroy
* @see app/Http/Controllers/Api/QuoteController.php:74
* @route '/api/quotes/{quote}'
*/
destroy.url = (args: { quote: string | number | { id: string | number } } | [quote: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { quote: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { quote: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            quote: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        quote: typeof args.quote === 'object'
        ? args.quote.id
        : args.quote,
    }

    return destroy.definition.url
            .replace('{quote}', parsedArgs.quote.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Api\QuoteController::destroy
* @see app/Http/Controllers/Api/QuoteController.php:74
* @route '/api/quotes/{quote}'
*/
destroy.delete = (args: { quote: string | number | { id: string | number } } | [quote: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Api\QuoteController::destroy
* @see app/Http/Controllers/Api/QuoteController.php:74
* @route '/api/quotes/{quote}'
*/
const destroyForm = (args: { quote: string | number | { id: string | number } } | [quote: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Api\QuoteController::destroy
* @see app/Http/Controllers/Api/QuoteController.php:74
* @route '/api/quotes/{quote}'
*/
destroyForm.delete = (args: { quote: string | number | { id: string | number } } | [quote: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

destroy.form = destroyForm

const quotes = {
    pdf: Object.assign(pdf, pdf),
    index: Object.assign(index, index),
    store: Object.assign(store, store),
    show: Object.assign(show, show),
    update: Object.assign(update, update),
    destroy: Object.assign(destroy, destroy),
}

export default quotes