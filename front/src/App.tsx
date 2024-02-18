import {Route, Routes } from "react-router-dom";
import * as comp from "@/components";
import Invoice from "@/pages/invoice";
import {NoMatch} from "@/components";
import {QueryClientProvider, QueryClient} from "@tanstack/react-query";

const queryClient = new QueryClient({
  defaultOptions: {
    queries: {
      staleTime: Infinity,
    },
  },
})

const App = () => {
  return (
    <QueryClientProvider client={queryClient}>
    <Routes>
        <Route element={<comp.Layout />}>
          <Route path="/" element={<Invoice />} />
          <Route path="*" element={<NoMatch />} />
        </Route>
      </Routes>
    </QueryClientProvider>
  );
}

export default App;
