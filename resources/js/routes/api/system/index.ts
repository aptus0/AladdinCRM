import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Api\SystemStatusController::__invoke
* @see app/Http/Controllers/Api/SystemStatusController.php:13
* @route '/api/system/status'
*/
export const status = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: status.url(options),
    method: 'get',
})

status.definition = {
    methods: ["get","head"],
    url: '/api/system/status',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Api\SystemStatusController::__invoke
* @see app/Http/Controllers/Api/SystemStatusController.php:13
* @route '/api/system/status'
*/
status.url = (options?: RouteQueryOptions) => {
    return status.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Api\SystemStatusController::__invoke
* @see app/Http/Controllers/Api/SystemStatusController.php:13
* @route '/api/system/status'
*/
status.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: status.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Api\SystemStatusController::__invoke
* @see app/Http/Controllers/Api/SystemStatusController.php:13
* @route '/api/system/status'
*/
status.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: status.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Api\SystemStatusController::__invoke
* @see app/Http/Controllers/Api/SystemStatusController.php:13
* @route '/api/system/status'
*/
const statusForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: status.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Api\SystemStatusController::__invoke
* @see app/Http/Controllers/Api/SystemStatusController.php:13
* @route '/api/system/status'
*/
statusForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: status.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Api\SystemStatusController::__invoke
* @see app/Http/Controllers/Api/SystemStatusController.php:13
* @route '/api/system/status'
*/
statusForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: status.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

status.form = statusForm

const system = {
    status: Object.assign(status, status),
}

export default system