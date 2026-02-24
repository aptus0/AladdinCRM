import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Api\OpportunityController::pipelineSummary
* @see app/Http/Controllers/Api/OpportunityController.php:48
* @route '/api/opportunities/pipeline-summary'
*/
export const pipelineSummary = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: pipelineSummary.url(options),
    method: 'get',
})

pipelineSummary.definition = {
    methods: ["get","head"],
    url: '/api/opportunities/pipeline-summary',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Api\OpportunityController::pipelineSummary
* @see app/Http/Controllers/Api/OpportunityController.php:48
* @route '/api/opportunities/pipeline-summary'
*/
pipelineSummary.url = (options?: RouteQueryOptions) => {
    return pipelineSummary.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Api\OpportunityController::pipelineSummary
* @see app/Http/Controllers/Api/OpportunityController.php:48
* @route '/api/opportunities/pipeline-summary'
*/
pipelineSummary.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: pipelineSummary.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Api\OpportunityController::pipelineSummary
* @see app/Http/Controllers/Api/OpportunityController.php:48
* @route '/api/opportunities/pipeline-summary'
*/
pipelineSummary.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: pipelineSummary.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Api\OpportunityController::pipelineSummary
* @see app/Http/Controllers/Api/OpportunityController.php:48
* @route '/api/opportunities/pipeline-summary'
*/
const pipelineSummaryForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: pipelineSummary.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Api\OpportunityController::pipelineSummary
* @see app/Http/Controllers/Api/OpportunityController.php:48
* @route '/api/opportunities/pipeline-summary'
*/
pipelineSummaryForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: pipelineSummary.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Api\OpportunityController::pipelineSummary
* @see app/Http/Controllers/Api/OpportunityController.php:48
* @route '/api/opportunities/pipeline-summary'
*/
pipelineSummaryForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: pipelineSummary.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

pipelineSummary.form = pipelineSummaryForm

/**
* @see \App\Http\Controllers\Api\OpportunityController::index
* @see app/Http/Controllers/Api/OpportunityController.php:20
* @route '/api/opportunities'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/api/opportunities',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Api\OpportunityController::index
* @see app/Http/Controllers/Api/OpportunityController.php:20
* @route '/api/opportunities'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Api\OpportunityController::index
* @see app/Http/Controllers/Api/OpportunityController.php:20
* @route '/api/opportunities'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Api\OpportunityController::index
* @see app/Http/Controllers/Api/OpportunityController.php:20
* @route '/api/opportunities'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Api\OpportunityController::index
* @see app/Http/Controllers/Api/OpportunityController.php:20
* @route '/api/opportunities'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Api\OpportunityController::index
* @see app/Http/Controllers/Api/OpportunityController.php:20
* @route '/api/opportunities'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Api\OpportunityController::index
* @see app/Http/Controllers/Api/OpportunityController.php:20
* @route '/api/opportunities'
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
* @see \App\Http\Controllers\Api\OpportunityController::store
* @see app/Http/Controllers/Api/OpportunityController.php:72
* @route '/api/opportunities'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/api/opportunities',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Api\OpportunityController::store
* @see app/Http/Controllers/Api/OpportunityController.php:72
* @route '/api/opportunities'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Api\OpportunityController::store
* @see app/Http/Controllers/Api/OpportunityController.php:72
* @route '/api/opportunities'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Api\OpportunityController::store
* @see app/Http/Controllers/Api/OpportunityController.php:72
* @route '/api/opportunities'
*/
const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Api\OpportunityController::store
* @see app/Http/Controllers/Api/OpportunityController.php:72
* @route '/api/opportunities'
*/
storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

store.form = storeForm

/**
* @see \App\Http\Controllers\Api\OpportunityController::show
* @see app/Http/Controllers/Api/OpportunityController.php:82
* @route '/api/opportunities/{opportunity}'
*/
export const show = (args: { opportunity: string | number | { id: string | number } } | [opportunity: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/api/opportunities/{opportunity}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Api\OpportunityController::show
* @see app/Http/Controllers/Api/OpportunityController.php:82
* @route '/api/opportunities/{opportunity}'
*/
show.url = (args: { opportunity: string | number | { id: string | number } } | [opportunity: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { opportunity: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { opportunity: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            opportunity: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        opportunity: typeof args.opportunity === 'object'
        ? args.opportunity.id
        : args.opportunity,
    }

    return show.definition.url
            .replace('{opportunity}', parsedArgs.opportunity.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Api\OpportunityController::show
* @see app/Http/Controllers/Api/OpportunityController.php:82
* @route '/api/opportunities/{opportunity}'
*/
show.get = (args: { opportunity: string | number | { id: string | number } } | [opportunity: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Api\OpportunityController::show
* @see app/Http/Controllers/Api/OpportunityController.php:82
* @route '/api/opportunities/{opportunity}'
*/
show.head = (args: { opportunity: string | number | { id: string | number } } | [opportunity: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Api\OpportunityController::show
* @see app/Http/Controllers/Api/OpportunityController.php:82
* @route '/api/opportunities/{opportunity}'
*/
const showForm = (args: { opportunity: string | number | { id: string | number } } | [opportunity: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Api\OpportunityController::show
* @see app/Http/Controllers/Api/OpportunityController.php:82
* @route '/api/opportunities/{opportunity}'
*/
showForm.get = (args: { opportunity: string | number | { id: string | number } } | [opportunity: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Api\OpportunityController::show
* @see app/Http/Controllers/Api/OpportunityController.php:82
* @route '/api/opportunities/{opportunity}'
*/
showForm.head = (args: { opportunity: string | number | { id: string | number } } | [opportunity: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
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
* @see \App\Http\Controllers\Api\OpportunityController::update
* @see app/Http/Controllers/Api/OpportunityController.php:87
* @route '/api/opportunities/{opportunity}'
*/
export const update = (args: { opportunity: string | number | { id: string | number } } | [opportunity: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put","patch"],
    url: '/api/opportunities/{opportunity}',
} satisfies RouteDefinition<["put","patch"]>

/**
* @see \App\Http\Controllers\Api\OpportunityController::update
* @see app/Http/Controllers/Api/OpportunityController.php:87
* @route '/api/opportunities/{opportunity}'
*/
update.url = (args: { opportunity: string | number | { id: string | number } } | [opportunity: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { opportunity: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { opportunity: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            opportunity: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        opportunity: typeof args.opportunity === 'object'
        ? args.opportunity.id
        : args.opportunity,
    }

    return update.definition.url
            .replace('{opportunity}', parsedArgs.opportunity.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Api\OpportunityController::update
* @see app/Http/Controllers/Api/OpportunityController.php:87
* @route '/api/opportunities/{opportunity}'
*/
update.put = (args: { opportunity: string | number | { id: string | number } } | [opportunity: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\Api\OpportunityController::update
* @see app/Http/Controllers/Api/OpportunityController.php:87
* @route '/api/opportunities/{opportunity}'
*/
update.patch = (args: { opportunity: string | number | { id: string | number } } | [opportunity: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Api\OpportunityController::update
* @see app/Http/Controllers/Api/OpportunityController.php:87
* @route '/api/opportunities/{opportunity}'
*/
const updateForm = (args: { opportunity: string | number | { id: string | number } } | [opportunity: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Api\OpportunityController::update
* @see app/Http/Controllers/Api/OpportunityController.php:87
* @route '/api/opportunities/{opportunity}'
*/
updateForm.put = (args: { opportunity: string | number | { id: string | number } } | [opportunity: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Api\OpportunityController::update
* @see app/Http/Controllers/Api/OpportunityController.php:87
* @route '/api/opportunities/{opportunity}'
*/
updateForm.patch = (args: { opportunity: string | number | { id: string | number } } | [opportunity: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
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
* @see \App\Http\Controllers\Api\OpportunityController::destroy
* @see app/Http/Controllers/Api/OpportunityController.php:94
* @route '/api/opportunities/{opportunity}'
*/
export const destroy = (args: { opportunity: string | number | { id: string | number } } | [opportunity: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/api/opportunities/{opportunity}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Api\OpportunityController::destroy
* @see app/Http/Controllers/Api/OpportunityController.php:94
* @route '/api/opportunities/{opportunity}'
*/
destroy.url = (args: { opportunity: string | number | { id: string | number } } | [opportunity: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { opportunity: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { opportunity: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            opportunity: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        opportunity: typeof args.opportunity === 'object'
        ? args.opportunity.id
        : args.opportunity,
    }

    return destroy.definition.url
            .replace('{opportunity}', parsedArgs.opportunity.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Api\OpportunityController::destroy
* @see app/Http/Controllers/Api/OpportunityController.php:94
* @route '/api/opportunities/{opportunity}'
*/
destroy.delete = (args: { opportunity: string | number | { id: string | number } } | [opportunity: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Api\OpportunityController::destroy
* @see app/Http/Controllers/Api/OpportunityController.php:94
* @route '/api/opportunities/{opportunity}'
*/
const destroyForm = (args: { opportunity: string | number | { id: string | number } } | [opportunity: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Api\OpportunityController::destroy
* @see app/Http/Controllers/Api/OpportunityController.php:94
* @route '/api/opportunities/{opportunity}'
*/
destroyForm.delete = (args: { opportunity: string | number | { id: string | number } } | [opportunity: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

destroy.form = destroyForm

const OpportunityController = { pipelineSummary, index, store, show, update, destroy }

export default OpportunityController