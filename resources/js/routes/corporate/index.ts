import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../wayfinder'
/**
* @see routes/web.php:23
* @route '/kurumsal'
*/
export const about = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: about.url(options),
    method: 'get',
})

about.definition = {
    methods: ["get","head"],
    url: '/kurumsal',
} satisfies RouteDefinition<["get","head"]>

/**
* @see routes/web.php:23
* @route '/kurumsal'
*/
about.url = (options?: RouteQueryOptions) => {
    return about.definition.url + queryParams(options)
}

/**
* @see routes/web.php:23
* @route '/kurumsal'
*/
about.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: about.url(options),
    method: 'get',
})

/**
* @see routes/web.php:23
* @route '/kurumsal'
*/
about.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: about.url(options),
    method: 'head',
})

/**
* @see routes/web.php:23
* @route '/kurumsal'
*/
const aboutForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: about.url(options),
    method: 'get',
})

/**
* @see routes/web.php:23
* @route '/kurumsal'
*/
aboutForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: about.url(options),
    method: 'get',
})

/**
* @see routes/web.php:23
* @route '/kurumsal'
*/
aboutForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: about.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

about.form = aboutForm

/**
* @see routes/web.php:29
* @route '/cozumler'
*/
export const solutions = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: solutions.url(options),
    method: 'get',
})

solutions.definition = {
    methods: ["get","head"],
    url: '/cozumler',
} satisfies RouteDefinition<["get","head"]>

/**
* @see routes/web.php:29
* @route '/cozumler'
*/
solutions.url = (options?: RouteQueryOptions) => {
    return solutions.definition.url + queryParams(options)
}

/**
* @see routes/web.php:29
* @route '/cozumler'
*/
solutions.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: solutions.url(options),
    method: 'get',
})

/**
* @see routes/web.php:29
* @route '/cozumler'
*/
solutions.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: solutions.url(options),
    method: 'head',
})

/**
* @see routes/web.php:29
* @route '/cozumler'
*/
const solutionsForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: solutions.url(options),
    method: 'get',
})

/**
* @see routes/web.php:29
* @route '/cozumler'
*/
solutionsForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: solutions.url(options),
    method: 'get',
})

/**
* @see routes/web.php:29
* @route '/cozumler'
*/
solutionsForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: solutions.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

solutions.form = solutionsForm

/**
* @see routes/web.php:35
* @route '/iletisim'
*/
export const contact = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: contact.url(options),
    method: 'get',
})

contact.definition = {
    methods: ["get","head"],
    url: '/iletisim',
} satisfies RouteDefinition<["get","head"]>

/**
* @see routes/web.php:35
* @route '/iletisim'
*/
contact.url = (options?: RouteQueryOptions) => {
    return contact.definition.url + queryParams(options)
}

/**
* @see routes/web.php:35
* @route '/iletisim'
*/
contact.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: contact.url(options),
    method: 'get',
})

/**
* @see routes/web.php:35
* @route '/iletisim'
*/
contact.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: contact.url(options),
    method: 'head',
})

/**
* @see routes/web.php:35
* @route '/iletisim'
*/
const contactForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: contact.url(options),
    method: 'get',
})

/**
* @see routes/web.php:35
* @route '/iletisim'
*/
contactForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: contact.url(options),
    method: 'get',
})

/**
* @see routes/web.php:35
* @route '/iletisim'
*/
contactForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: contact.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

contact.form = contactForm

const corporate = {
    about: Object.assign(about, about),
    solutions: Object.assign(solutions, solutions),
    contact: Object.assign(contact, contact),
}

export default corporate